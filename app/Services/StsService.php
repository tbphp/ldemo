<?php

namespace App\Services;

use AlibabaCloud\SDK\Sts\V20150401\Models\AssumeRoleRequest;
use AlibabaCloud\SDK\Sts\V20150401\Sts;
use Darabonba\OpenApi\Models\Config;

class StsService
{
    /**
     * 生成
     * @return array
     */
    public static function gen(): array
    {
        $config = new Config([
            'accessKeyId' => config('filesystems.disks.oss.access_key'),
            'accessKeySecret' => config('filesystems.disks.oss.secret_key'),
        ]);

        $config->endpoint = 'sts.cn-hangzhou.aliyuncs.com';

        $request = new AssumeRoleRequest([
            'roleArn' => config('filesystems.disks.oss.arn'),
            'roleSessionName' => 'hyperhash-img',
            'durationSeconds' => 900,
        ]);

        $sts = new Sts($config);
        $res = $sts->assumeRole($request)->body->credentials->toMap();
        $res['Region'] = config('filesystems.disks.oss.region', 'oss-cn-hangzhou');
        $res['Bucket'] = config('filesystems.disks.oss.bucket');

        return $res;
    }
}
