<?php

namespace app\controller\admin;


use app\common\library\ArrayLib;
use think\facade\Db;

class Privilege extends AdminBase
{
    public function lst()
    {
        $p = Db::name('u_privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $data = ArrayLib::getTree($p);
        $ret = [
            'data'           => $data,

        ];

        return view('admin/u_privilege/lst', $ret);
    }
}
