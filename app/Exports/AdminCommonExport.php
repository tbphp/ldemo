<?php

namespace App\Exports;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AdminCommonExport implements FromArray, WithStrictNullComparison
{
    protected array $keys = [];

    protected array $headers;

    protected array $data;

    protected array $dates = ['created_at', 'updated_at'];

    public function __construct(array $headers, array $data, array $dates = [])
    {
        if (array_key_first($headers) !== 0) {
            $this->keys = array_keys($headers);
        }

        if ($dates) {
            $this->dates = array_merge($this->dates, $dates);
        }

        $this->headers = array_values($headers);
        $this->data = $data;
    }

    public function array(): array
    {
        $result = [$this->headers];

        if ($this->keys) {
            foreach ($this->data as $datum) {
                $r = [];
                foreach ($this->keys as $key) {
                    // 处理点分隔
                    if (strpos($key, '.') !== false) {
                        $val = Arr::get($datum, $key, '');
                    } else {
                        $val = $datum[$key] ?? '';
                    }
                    if (in_array($key, $this->dates) && !empty($val)) {
                        $r[] = Date::createFromTimestamp($val)->toDateTimeString();
                    } else {
                        $r[] = $val;
                    }
                }
                $result[] = $r;
            }
        } else {
            $result = array_merge($result, $this->data);
        }

        return $result;
    }
}
