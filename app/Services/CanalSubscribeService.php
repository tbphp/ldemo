<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;

class CanalSubscribeService
{
    private string $table;

    private array $events = [];

    private array $columns = [];

    private array $extra = [];

    private string $queue = 'canal';

    private int $delay = 0;

    /**
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        // 解析表名
        if (class_exists($table)) {
            /** @var Model $instance */
            $instance = new $table;
            if (!$instance instanceof Model) {
                throw new Exception('传入的 $table 入参并非支持的模型类');
            }
            $this->table = $instance->getTable();
        } else {
            $this->table = $table;
        }
    }

    public function columns($columns): self
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function events($events): self
    {
        $this->events = is_array($events) ? $events : func_get_args();
        return $this;
    }

    public function extra(array $extra): self
    {
        $this->extra = $extra;
        return $this;
    }

    public function queue(string $queue): self
    {
        $this->queue = $queue;
        return $this;
    }

    public function delay(int $seconds): self
    {
        $this->delay = $seconds;
        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }

    public function getQueue(): string
    {
        return $this->queue;
    }

    public function getDelay(): int
    {
        return $this->delay;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param array $data
     * @return void
     * @throws Exception
     */
    public static function __set_state(array $data): self
    {
        $obj = new self($data['table']);
        $obj->events = $data['events'];
        $obj->columns = $data['columns'];
        $obj->extra = $data['extra'];
        $obj->queue = $data['queue'];
        $obj->delay = $data['delay'];
        return $obj;
    }
}
