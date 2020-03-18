<?php

namespace app\controller\test;


use app\BaseController;
use think\App;

class TestBase extends BaseController
{
   public function __construct(App $app)
   {
       parent::__construct($app);
   }



}
