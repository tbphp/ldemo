<?php

namespace App\Services\Logging;

use DateTimeInterface;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Formatter\NormalizerFormatter;

class JsonLogFormatter extends LogstashFormatter
{
    public function __construct($applicationName)
    {
        parent::__construct($applicationName);
    }

    protected function formatDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function format(array $record): string
    {
        $record = NormalizerFormatter::format($record);
        if (empty($record['datetime'])) {
            $record['datetime'] = gmdate('c');
        }
        $message = [
            'time' => $record['datetime'],
            'hostname' => $this->systemName,
            'product' => $this->applicationName,
        ];

        if (isset($record['channel'])) {
            $message['channel'] = $record['channel'];
        }

        if (isset($record['level'])) {
            $message['level'] = $record['level'];
        }

        if (isset($record['level_name'])) {
            $message['level_name'] = $record['level_name'];
        }

        $message['is_access'] = $record['message'] === 'access';

        if (isset($record['message'])) {
            $message['message'] = $record['message'];
        }

        if (isset($record['context'])) {
            $message['context'] = $this->toJson($record['context']);
        }

        if (isset($record['context']['extra']) && is_array($record['context']['extra']) && $record['context']['extra']) {
            $message['extra'] = $record['context']['extra'];
        }

        $message['ip'] = request()->ip();

        return $this->toJson($message) . "\n";
    }
}
