<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use JWTAuth;

class AuthJWT
{
    public function handle($request, Closure $next)
    {

        //.env 里的 JWT_TTL 设置token和cookie的过期时间。
        //如果token有问题返回错误，前端自己清除cookie然后后重新走登陆。

        try {
            // 如果用户登陆后的所有请求没有jwt的token抛出异常
            $user = JWTAuth::parseToken()->authenticate();
            $request->user = $user;
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json([
                    'code' => 1,
                    'message' => 'Token 已过期',
                    'data' =>(object)null,
                ],401);
            }elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'code' => 2,
                    'message' => 'Token 无效',
                    'data' =>(object)null,
                ],401);
            }else{
                return response()->json([
                    'code' => 3,
                    'message' => 'Token 出错了',
                    'data' =>(object)null,
                ],401);
            }
        }
        return $next($request);
    }
}
