<?php

namespace App\Jobs;

use App\Enums\CanalEventEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

abstract class AbstractCanalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string 表名
     */
    protected string $table;

    /**
     * @var CanalEventEnum 事件
     */
    protected CanalEventEnum $event;

    /**
     * @var array 影响的字段列表
     */
    protected array $columns;

    /**
     * @var array 原始（修改前）数据
     */
    protected array $original;

    /**
     * @var array 当前（修改后）数据
     */
    protected array $data;

    /**
     * @var array 扩展数据，canal.subscribes配置里面自定义传值
     */
    protected array $extra;

    /**
     * @var string 延迟任务key
     */
    protected string $delayKey;

    public function __construct(string $table, CanalEventEnum $event, array $data, array $extra, string $delayKey = '')
    {
        $this->table = $table;
        $this->event = $event;
        $this->columns = $data['columns'] ?? [];
        $this->original = $data['original'] ?? [];
        $this->data = $data['data'] ?? [];
        $this->extra = $extra;
        $this->delayKey = $delayKey;
    }

    public function handle()
    {
        // 延迟任务一旦开始就释放锁
        !empty($this->delayKey) && Cache::forget($this->delayKey);

        $job = class_basename(get_called_class());
        Log::info('canal_job ' . $job, [
            'job' => $job,
            'table' => $this->table,
            'event' => $this->event->description,
            'columns' => $this->columns,
            'original' => $this->original,
            'data' => $this->data,
            'extra' => $this->extra,
        ]);

        $this->script();
    }

    abstract public function script();

    /**
     * 判断表
     *
     * @param string|array $tables 表名或者模型类
     * @return bool
     */
    protected function inTable($tables): bool
    {
        $tables = is_array($tables) ? $tables : func_get_args();

        foreach ($tables as $table) {
            if (class_exists($table)) {
                /** @var Model $instance */
                $instance = new $table;
                if (!$instance instanceof Model) {
                    continue;
                }
                $table = $instance->getTable();
                if ($table === $this->table) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 延迟分发的唯一Key
     *
     * @param string $table
     * @param array $data
     * @return string
     */
    public static function delayKey(string $table, array $data): string
    {
        return hash('sha256', $table);
    }

    /**
     * 延迟分发
     *
     * @param string $table
     * @param CanalEventEnum $event
     * @param array $data
     * @param array $extra
     * @param string $queue
     * @param int $seconds
     */
    public static function delayDispatch(
        string         $table,
        CanalEventEnum $event,
        array          $data,
        array          $extra,
        string         $queue,
        int            $seconds
    )
    {
        $now = now();
        $key = class_basename(get_called_class()) . ':' . static::delayKey($table, $data['data'] ?? []);

        // 分发锁
        $lockKey = 'canal_delay_lock:' . $key;
        if (Cache::has($lockKey)) {
            return;
        }

        $cacheKey = 'canal_delay_job:' . $key;
        $cacheTtl = $now->copy()->addSeconds($seconds * 10);

        /** @var Carbon $nextAt */
        $nextAt = Cache::get($cacheKey, $now);
        $recordAt = $nextAt->max($now)->copy()->addSeconds($seconds);

        Cache::put($lockKey, 1, $cacheTtl);
        Cache::put($cacheKey, $recordAt, $cacheTtl);

        static::dispatch($table, $event, $data, $extra, $lockKey)
            ->onQueue($queue)
            ->delay($nextAt->gt($now) ? $nextAt : null);
    }
}
