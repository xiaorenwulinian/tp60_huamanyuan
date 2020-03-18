<?php

namespace app\controller\test;



use think\facade\Config;
use think\model\Relation;

class DbTestV1 extends TestBase
{
    public function test() {
        return $this->method1();
        return $this->method2();
    }

    /**
     *  验证失败抛出异常
     * @return bool|string
     */
    public function method1()
    {
        $goods = \think\facade\Db::table('goods')->via()->alias()->select();
        dd($goods);

        $db = new Db();
        $ret = $db->table('goods')->select();
        dd($ret);
//        Request::instance()
        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }

}
