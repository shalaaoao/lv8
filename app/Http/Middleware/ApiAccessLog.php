<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

/**
 * 基础接口访问日志
 */
class ApiAccessLog
{
    // 需要返回值的白名单
    const RESPONSE_DATA_PATHS = [

    ];

    public function handle(Request $request, Closure $next)
    {
        try {
            $resp = $next($request);
        } finally {
            $method     = $request->method();
            $uri        = $request->path();
            $ip         = $request->ip();
            $ua         = $request->header('User-Agent');
            $shopId     = $request->header('shopId');
            $brandId    = $request->header('brandId');
            $params     = json_encode($request->all() ?? []);
            $statusCode = $resp->getStatusCode();
            $ms         = floor((microtime(true) - LARAVEL_START) * 1000) . 'ms';
            $userId     = auth('api')->id();

            if (in_array($request->path(), self::RESPONSE_DATA_PATHS)) {
                $response = (string)$resp->getContent();
            } else {
                $response = '';
            }

            $log = "[$ip] [$method] [$uri] [$params] [$ua] [$shopId] [$brandId] [$userId] [$statusCode] [$response] [$ms]";
            Log::channel('apiAccess')->info($log);
        }

        return $resp;
    }
}
