<?php

namespace App\Console\Commands;

use App\Enums\CanalEventEnum;
use App\Jobs\AbstractCanalJob;
use App\Services\CanalSubscribeService;
use Com\Alibaba\Otter\Canal\Protocol\Column;
use Com\Alibaba\Otter\Canal\Protocol\Entry;
use Com\Alibaba\Otter\Canal\Protocol\EntryType;
use Com\Alibaba\Otter\Canal\Protocol\RowChange;
use Com\Alibaba\Otter\Canal\Protocol\RowData;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use xingwenge\canal_php\CanalClient;
use xingwenge\canal_php\CanalConnectorFactory;

class CanalServerCommand extends Command
{
    protected $signature = 'canal-server';

    protected $description = 'Canal Server';

    /**
     * @var array 订阅规则
     */
    protected array $subscribes;

    /**
     * @var array 订阅相关的表名列表
     */
    protected array $subscribeTables;

    public function __construct()
    {
        parent::__construct();

        $this->subscribes = $this->parseSubscribes();
        $this->subscribeTables = array_keys($this->subscribes);
    }

    public function handle(): int
    {
        try {
            // 连接并订阅canal
            $client = CanalConnectorFactory::createClient(CanalClient::TYPE_SOCKET_CLUE);
            $client->connect(config('canal.server.host'), config('canal.server.port'));
            $client->checkValid();
            $client->subscribe(
                config('canal.server.client'),
                config('canal.server.destination'),
                config('database.connections.mysql.database') . '\\..*'
            );

            // 循环记数，达到maxtimes后结束进程，避免内存泄漏
            $times = 0;
            while (true) {
                $message = $client->get();
                if ($entries = $message->getEntries()) {
                    $times++;
                    /** @var Entry $entry */
                    foreach ($entries as $entry) {
                        // 过滤无效的实体
                        if (in_array($entry->getEntryType(), [
                            EntryType::TRANSACTIONBEGIN,
                            EntryType::TRANSACTIONEND,
                        ])) {
                            continue;
                        }

                        // 获取行数据
                        $row = new RowChange();
                        $row->mergeFromString($entry->getStoreValue());

                        // 过滤操作类型
                        $event = $row->getEventType();
                        if (!CanalEventEnum::hasValue($event)) {
                            continue;
                        }
                        $event = CanalEventEnum::fromValue($event);

                        // 过滤非订阅表
                        $table = $entry->getHeader()->getTableName();
                        if (!in_array($table, $this->subscribeTables)) {
                            continue;
                        }

                        /** @var RowData $rowData */
                        foreach ($row->getRowDatas() as $rowData) {
                            $data = $this->parseData($event, $rowData);
                            $this->dispatchData($table, $event, $data);
                        }
                    }
                }

                if ($times >= config('canal.server.max_times')) {
                    break;
                }
            }
            $client->disConnect();
        } catch (Exception $e) {
            Log::error('canal_server_error ' . $e->getMessage(), $e->getTrace());
            sleep(10);
        }

        return self::SUCCESS;
    }

    /**
     * 解析订阅规则
     *
     * @return array
     */
    protected function parseSubscribes(): array
    {
        $canalSubscribes = config('canal.subscribes');
        $data = [];
        foreach ($canalSubscribes as $job => $subscribes) {
            // $table
            /** @var CanalSubscribeService $subscribe */
            foreach ($subscribes as $subscribe) {
                $table = $subscribe->getTable();
                foreach ($subscribe->getEvents() as $event) {
                    $data[$table][$event][] = compact('job', 'subscribe');
                }
            }
        }
        return $data;
    }

    /**
     * 解析数据
     *
     * @param CanalEventEnum $event
     * @param RowData $rowData
     *
     * @return array
     */
    protected function parseData(CanalEventEnum $event, RowData $rowData): array
    {
        $columns = [];
        $afterData = [];
        /** @var Column $afterColumn */
        foreach ($rowData->getAfterColumns() as $afterColumn) {
            if ($afterColumn->getUpdated()) {
                $columns[] = $afterColumn->getName();
            }
            $afterData[$afterColumn->getName()] = $afterColumn->getValue();
        }

        $data = [
            'columns' => $columns,
            'original' => [],
            'data' => $afterData,
        ];

        if ($event->isNot(CanalEventEnum::INSERT)) {
            $beforeData = [];
            $bcolumns = [];
            /** @var Column $before_column */
            foreach ($rowData->getBeforeColumns() as $before_column) {
                $beforeData[$before_column->getName()] = $before_column->getValue();
                $bcolumns[] = $before_column->getName();
            }
            if (empty($data['columns'])) {
                $data['columns'] = $bcolumns;
            }
            $data['original'] = $beforeData;
        }

        return $data;
    }

    /**
     * 分发数据
     *
     * @param string $table
     * @param CanalEventEnum $event
     * @param array $data
     * @return void
     */
    protected function dispatchData(string $table, CanalEventEnum $event, array $data)
    {
        if (empty($table) || empty($data) || empty($this->subscribes[$table][$event->value])) {
            return;
        }

        $subscribes = $this->subscribes[$table][$event->value];
        /**
         * @var CanalSubscribeService $subscribe
         * @var AbstractCanalJob $job
         */
        foreach ($subscribes as ['job' => $job, 'subscribe' => $subscribe]) {
            // 匹配字段
            if ($event->is(CanalEventEnum::UPDATE)
                && !in_array('*', $subscribe->getColumns())
                && empty(array_intersect($subscribe->getColumns(), $data['columns']))) {
                continue;
            }

            $queue = $subscribe->getQueue();

            // 延迟分发
            $delay = $subscribe->getDelay();
            if ($delay > 0) {
                $job::delayDispatch($table, $event, $data, $subscribe->getExtra(), $queue, $delay);
            } else {
                $job::dispatch($table, $event, $data, $subscribe->getExtra())->onQueue($queue);
            }
        }
    }
}
