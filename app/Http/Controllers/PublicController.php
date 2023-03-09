<?php

namespace App\Http\Controllers;

use App\Services\StsService;
use Exception;

class PublicController extends Controller
{
    /**
     * 获取oss临时令牌
     *
     * @return array
     * @throws Exception
     */
    public function ossSts(): array
    {
        return StsService::gen();
    }
}
