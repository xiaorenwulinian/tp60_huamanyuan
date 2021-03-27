<?php

namespace app\middleware;


use app\common\library\LclJwtLib;

class MiniProgramAuthCheck
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $wechat = LclJwtLib::getInstance()->getWeChatInfoMiniProgram();
        if ( empty($wechat)) {
            return failed_response('非法攻击～！');
        }
        return $next($request);
    }
}
