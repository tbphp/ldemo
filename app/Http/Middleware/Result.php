<?php

namespace App\Http\Middleware;

use App\Enums\LangEnum;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class Result
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|Response
     */
    public function handle(Request $request, Closure $next)
    {
        // 强制请求为json类型
        $request->headers->set('Accept', 'application/json');

        // 语言设置
        $lang = $request->header('X-Lang');
        if ($lang && LangEnum::hasValue($lang)) {
            App::setLocale($lang);
        } elseif ($request->is('admin/*')) {
            App::setLocale(LangEnum::ZH_CN);
        } else {
            App::setLocale(config('app.locale'));
        }

        // 更新语言标记
        if (Auth::check()) {
            $member = Auth::user();
            if ($member->lang !== App::getLocale()) {
                $member->update(['lang' => App::getLocale()]);
            }
        }

        // 记录访问日志
        $accessLog = [
            'uid' => (int)Auth::id(),
            'method' => $request->method(),
            'path' => $request->path(),
            'params' => json_encode($request->all()),
            'user_agent' => $request->userAgent(),
        ];
        Log::info('access', ['extra' => $accessLog]);

        /** @var Response $response */
        $response = $next($request);

        // 过滤
        if ($this->filter($request, $response)) {
            return $response;
        }

        // 处理公共返回
        $result = [
            'code' => 1,
            'msg' => 'ok',
            'data' => (object)json_decode($response->getContent()),
        ];

        return response()->json($result);
    }

    /**
     * 过滤不需要处理的返回
     *
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    private function filter(Request $request, Response $response): bool
    {
        if (property_exists($response, 'exception') && $response->exception) {
            return true;
        }

        if ($request->is(config('app.filter_urls.result'))) {
            return true;
        }

        if ($response instanceof BinaryFileResponse) {
            return true;
        }

        return false;
    }
}
