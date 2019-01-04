<?php

namespace App\Http\Middleware;

use Closure;

class SwitchGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 获取路由前缀
        $prefix = $request->route()->getPrefix();
        switch ($prefix){
            case 'api/h':
                Config::set('jwt.secret', Config::get('jwt.secret_b'));  //Config::get('jwt.secret_b')在配置文件中设置
                Config::set('auth.defaults.guard', 'h');  // 这里就是让他走 guards 的 b 子项 之后会走 providers->b->'model' => App\Model\BUser::class,  //这里是所要验证的表所对应的模型
                break;

        }
        return $next($request);
    }
}
