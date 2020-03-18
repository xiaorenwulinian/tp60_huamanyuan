<?php

namespace app\controller\miniprogram;


use app\BaseController;
use think\App;

class MiniProgramBase extends BaseController
{
   public function __construct(App $app)
   {
       parent::__construct($app);
   }

    public function getDomain()
    {
        $domain = request()->domain();
        if (preg_match("/^http:\/\/127\.0\.0\.1/i", $domain)) {
            $domain = config("app.domain_test");
        }
        return $domain;
    }

    /**
     * 获取图片显示全路径
     * @return string
     */
    public function getImgRootPath()
    {
        $domain = request()->domain();
        if (preg_match("/^http:\/\/127\.0\.0\.1/i", $domain)) {
            $domain = config("app.domain_test");
        }
        $imgRootPath = $domain . "/uploads/";
        return $imgRootPath;
    }

}
