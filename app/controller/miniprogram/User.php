<?php

namespace app\controller\miniprogram;


use app\common\library\LclJwtLib;
use think\App;

class User extends MiniProgramBase
{
   public function __construct(App $app)
   {
       parent::__construct($app);
   }

   public function detail()
   {
       $wechatInfo = LclJwtLib::getInstance()->getWeChatInfoMiniProgram();
       if (empty($wechatInfo['phone'])) {
           return failed_response('', 418);
       }
       return success_response(compact('userId'));
   }

}
