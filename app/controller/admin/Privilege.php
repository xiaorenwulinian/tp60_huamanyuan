<?php

namespace app\controller\admin;


use app\common\library\ArrayLib;
use think\facade\Db;

class Privilege extends AdminBase
{
    public function lst()
    {
        $p = Db::name('privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $data = ArrayLib::getTree($p);
        $ret = [
            'data'           => $data,

        ];

        return view('admin/privilege/lst', $ret);
    }


    public function add()
    {
        $reqParam = $this->request->param();
        if ($this->request->isPost()) {

            $this->validate($reqParam, [

                'privilege_name' => 'require|max:255',

            ]);

            Db::name('privilege')->insertGetId([
                'parent_id' => $reqParam['parent_id'],
                'is_menu' => $reqParam['is_menu'],
                'is_show' => $reqParam['is_show'],
                'privilege_name' => $reqParam['privilege_name'],
                'route_url' => !empty($reqParam['route_url']) ? $reqParam['route_url'] : '',
                'identify' => !empty($reqParam['identify']) ? $reqParam['identify'] : '',
                'pri_icon' => !empty($reqParam['pri_icon']) ? $reqParam['pri_icon'] : '',
                'sort_id' => !empty($reqParam['sort_id']) ? $reqParam['sort_id'] : 1,
            ]);


            return success_response();
        }

        $p = Db::name('privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $privilege = ArrayLib::getTree($p);

        $ret = [
            'priData'   => $privilege,
        ];

        return view('admin/privilege/add', $ret);

    }

    public function edit()
    {
        $id = $this->request->param('id');
        if ($this->request->isPost()) {

            $reqParam = $this->request->param();

            $this->validate($reqParam, [
                'id' => 'require|integer',
                'privilege_name' => 'require|max:255',

            ]);

            Db::name('privilege')
                ->where('id', $id)
                ->update([
                    'parent_id' => $reqParam['parent_id'],
                    'is_menu' => $reqParam['is_menu'],
                    'is_show' => $reqParam['is_show'],
                    'privilege_name' => $reqParam['privilege_name'],
                    'route_url' => !empty($reqParam['route_url']) ? $reqParam['route_url'] : '',
                    'identify' => !empty($reqParam['identify']) ? $reqParam['identify'] : '',
                    'pri_icon' => !empty($reqParam['pri_icon']) ? $reqParam['pri_icon'] : '',
                    'sort_id' => !empty($reqParam['sort_id']) ? $reqParam['sort_id'] : 1,
                ]);

            return success_response();
        }

        $data = Db::table('privilege')->find($id);

        $pri = Db::name('privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $privilege = ArrayLib::getTree($pri);


        $ret = [
            'priData'   => $privilege,
            'data'    => $data,


        ];

        return view('admin/privilege/edit', $ret);
    }

    public function changeShow()
    {
        $id = $this->request->param('id');
        $data = Db::name('privilege')
            ->where('id', $id)
            ->find();

        $isShow   = $data['is_show'] == 1 ? 2 : 1;
        Db::name('privilege')
            ->where('id', $id)
            ->update([
                'is_show' => $isShow
            ]);

        return success_response();
    }

    public function changeMenu()
    {
        $id = $this->request->param('id');
        $data = Db::name('privilege')
            ->where('id', $id)
            ->find();

        $isShow   = $data['is_menu'] == 1 ? 2 : 1;
        Db::name('privilege')
            ->where('id', $id)
            ->update([
                'is_menu' => $isShow
            ]);

        return success_response();
    }


    public function editSort()
    {
        $id = $this->request->param('id');
        $sort_id = $this->request->param('sort_id');

        Db::name('privilege')
            ->where('id', $id)
            ->update([
                'sort_id' => $sort_id
            ]);

        return success_response();
    }

    public function delete()
    {
        $id = $this->request->param('id');
        $sort_id = $this->request->param('sort_id');

        Db::name('privilege')
            ->where('id', $id)
            ->update([
                'sort_id' => $sort_id
            ]);

        return success_response();
    }

}
