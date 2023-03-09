<?php

use App\Enums\ErrCodeEnum;
use App\Exceptions\DefaultException;
use App\Exports\AdminCommonExport;
use App\Services\CanalSubscribeService;
use Iidestiny\Flysystem\Oss\OssAdapter;
use Illuminate\Contracts\Cache\Lock;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * laravel-s 进程模式调试方法
 *
 * @param string $message 消息
 * @param array $context 扩展内容
 */
function s(string $message, array $context = [])
{
    Log::channel('stderr')->debug($message, $context);
}

/**
 * 记录sql的开始点
 */
function sql_start()
{
    DB::flushQueryLog();
    DB::enableQueryLog();
}

/**
 * 获取从开始点记录的所有sql
 */
function sql(): array
{
    return DB::getQueryLog();
}

/**
 * 添加表注释
 *
 * @param string $table_name 表名
 * @param string $comment 注释内容
 */
function table_comment(string $table_name, string $comment)
{
    DB::statement('ALTER TABLE `' . $table_name . '` comment "' . $comment . '"');
}

/**
 * 获取原子锁，用于防止并发
 *
 * 使用示例：
 *  ```php
 *  $lock = lock('customize_lock_key');
 *  if (!$lock->get()) {
 *      throw new DefaultException('操作频繁，请稍后再试');
 *  }
 *  # 业务逻辑代码...
 *  $lock->release(); // 释放锁
 *  ```
 *
 * @param string $key 原子锁字符串key
 * @param int $seconds 死锁时间（单位秒），需要大于逻辑执行时间。
 * @param mixed $owner
 * @return mixed
 */
function lock(string $key, int $seconds = 60, $owner = null): Lock
{
    return Cache::lock('lock:' . $key, $seconds, $owner);
}

/**
 * 上传文件
 *
 * @param string|File|UploadedFile $file 文件路径或者File对象
 * @param string $name 文件名
 * @param string $path 目录
 * @param int $tempTtl 临时文件访问有效期，如果未设置则为公共读取
 * @return string[]
 */
function upload($file, string $name = '', string $path = '', int $tempTtl = 0, string $filesystemsDriver = ''): array
{
    if (is_string($file) && file_exists($file)) {
        $file = new File($file);
    }

    if (empty($name)) {
        if ($file instanceof UploadedFile) {
            $name = Str::random(40) . '.' . $file->getClientOriginalExtension();
        } elseif ($file instanceof File) {
            $name = Str::random(40) . '.' . $file->getExtension();
        } else {
            throw new DefaultException('缺少name入参');
        }
    }

    if (empty($path) && $filesystemsDriver !== 'nft') {
        $path = now()->format('Y-m-d');
    }

    /** @var OssAdapter|Storage $disk */
    if (!empty($filesystemsDriver)) {
        $disk = Storage::disk($filesystemsDriver);
    } else {
        $disk = Storage::disk();
    }

    $key = $disk->putFileAs($path, $file, $name);

    if ($tempTtl > 0) {
        $url = $disk->signUrl($key, $tempTtl);

        /** @noinspection PhpUndefinedMethodInspection */
        $kernel = $disk->kernel();
        $kernel->putObjectAcl(config('filesystems.disks.oss.bucket'), $key, 'private');
    } else {
        $url = Storage::url($key);
    }

    return [
        'key' => $key,
        'url' => $url,
    ];
}

function create_order_no(): string
{
    return date('ymdHis') . mt_rand(10000, 99999);
}

/**
 * canal 订阅
 *
 * @param string $table 表名或模型类
 * @return CanalSubscribeService|null
 */
function subscribe(string $table): ?CanalSubscribeService
{
    try {
        return new CanalSubscribeService($table);
    } catch (Exception $e) {
        abort(500, $e->getMessage());
    }
}

/**
 * 固定导出方法
 *
 * @param string $filename
 * @param array $data
 * @param array $headers
 * @param array $dates
 * @return BinaryFileResponse
 */
function exportExcel(string $filename, array $data, array $headers = [], array $dates = []): BinaryFileResponse
{
    $export = new AdminCommonExport($headers, $data, $dates);
    return Excel::download($export, $filename . '_' . now()->format('YmdHis') . '.xlsx');
}

/**
 * 发送飞书消息
 *
 * @param string $title
 * @param string $content
 * @param array $options
 * @return bool
 */
function feishu_msg(string $title, string $content, array $options = []): bool
{
    $channel = $options['channel'] ?? 'monitor';
    $jumpUrl = $options['url'] ?? '';
    $type = $options['type'] ?? 'default';
    $btn = $options['btn'] ?? '查看';
    $config = config('feishu.channel.' . $channel);
    $time = time();

    $templates = [
        'default' => 'turquoise',
        'info' => 'wathet',
        'success' => 'green',
        'warn' => 'orange',
        'error' => 'red',
        'fail' => 'grey',
    ];

    $template = $templates[$type] ?? $templates['default'];

    // 计算签名
    $signData = $time . PHP_EOL . $config['secret'];
    $sign = base64_encode(hash_hmac('sha256', '', $signData, true));

    $contents = [[
        'tag' => 'markdown',
        'content' => $content,
    ]];

    if ($jumpUrl) {
        $contents[] = ['tag' => 'hr'];
        $contents[] = [
            'tag' => 'action',
            'actions' => [[
                'tag' => 'button',
                'text' => [
                    'content' => $btn,
                    'tag' => 'plain_text',
                ],
                'type' => 'default',
                'url' => $jumpUrl,
            ]],
        ];
    }

    $response = Http::baseUrl(config('feishu.api_url'))->post($config['token'], [
        'timestamp' => $time,
        'sign' => $sign,
        'msg_type' => 'interactive',
        'card' => [
            'header' => [
                'title' => [
                    'content' => $title,
                    'tag' => 'plain_text',
                ],
                'template' => $template,
            ],
            'elements' => $contents,
        ],
    ]);

    if ($response->successful() && $response->json('StatusCode') === 0) {
        return true;
    }

    Log::error('feishu_error', $response->json());

    return false;
}

/**
 * IP白名单
 *
 * @param string|string[] $ips
 */
function whitelist($ips)
{
    if (config('app.debug')) {
        return;
    }

    if (!is_array($ips)) {
        $ips = func_get_args();
    }

    if (!in_array(request()->ip(), $ips)) {
        Log::warning('whitelist_error', ['current' => request()->ip(), 'ips' => $ips]);
        abort(ErrCodeEnum::HTTP_AUTHORIZATION, 'Forbidden');
    }
}
