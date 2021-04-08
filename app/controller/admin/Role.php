<?php

namespace app\controller\admin;


use app\common\library\ArrayLib;
use think\facade\Db;

class Role extends AdminBase
{


    public function privilegeByRoleId()
    {
        $reqParam = $this->request->param();

        $this->validate($reqParam, [

            'id' => 'require|max:255',

        ]);


        $privilege_id = Db::name('role')
            ->where([
                'id' => $reqParam['id'],
            ])->value('privilege_id');
        $ret = [
            'privilege_id' => $privilege_id
        ];

        return success_response($ret);
    }

    public function lst()
    {
        $pageSize = input('page_size', 10); // 每一页默认显示的条数
        $pageSizeSelect = page_size_select($pageSize); //生成下拉选择页数框

        $where = [];
        $title = input('name', '');
        if (!empty($title)) {
            $where[] = ['name', 'like', "%{$title}%"];
        }

        $data = Db::name('role')->where($where)
            ->order('id','desc')
            ->paginate([
                'query'     => request()->param(),
                'list_rows' => $pageSize, //每页数量
            ],false);
//       dd($data);
        $pageShow = $data->render();
        $companyData = [];


        $ret = [
            'data'           => $data,
            'pageSizeSelect' => $pageSizeSelect,
            'pageSize'       => $pageSize,
            'pageShow'       => $pageShow,
            'companyData'       => $companyData,
        ];
        return view('admin/role/lst', $ret);
    }

    public function add()
    {
        $reqParam = $this->request->param();
        if ($this->request->isPost()) {

            $this->validate($reqParam, [

                'role_name' => 'require|max:255',
                'privilege_ids' => 'require|max:255',
                'relation_id' => 'require|integer',

            ]);
            $curDate = date('Y-m-d H:i:s');
            $roleId = Db::name('role')->insertGetId([
                'role_name' => $reqParam['role_name'],
                'relation_id' => $reqParam['relation_id'],
                'privilege_id' => $reqParam['privilege_ids'],
                'role_desc' => !empty($reqParam['role_desc']) ? $reqParam['role_desc'] : '',
                'create_time' => $curDate,
                'update_time' => $curDate,
            ]);

            return success_response();
        }
        $role = Db::name('role')
            ->where('is_delete',2)
            ->select()
            ->toArray();

        $p = Db::name('privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $privilege = ArrayLib::getTree($p);
        $ret = [
            'priData'   => $privilege,
            'roleData'   => $role,
        ];

        return view('admin/role/add', $ret);

    }

    public function edit()
    {
        $id = $this->request->param('id');
        if ($this->request->isPost()) {
            $reqParam = $this->request->param();

            $this->validate($reqParam, [

                'id' => 'require|integer',
                'role_name' => 'require|max:255',
                'privilege_ids' => 'require|max:255',

            ]);
            $curDate = date('Y-m-d H:i:s');
            Db::name('role')
                ->where('id', $id)
                ->update([
                    'role_name' => $reqParam['role_name'],
                    'relation_id' => $reqParam['relation_id'],
                    'privilege_id' => $reqParam['privilege_ids'],
                    'role_desc' => !empty($reqParam['role_desc']) ? $reqParam['role_desc'] : '',
                    'update_time' => $curDate,
                ]);

            return success_response();
        }
        $data = Db::table('role')->find($id);
        $hasPri = $data['privilege_id'];
        $hasPriArr = [];
        if (!empty($hasPri)) {
            $hasPriArr = explode(',',$hasPri);
        }

        $p = Db::name('privilege')
            ->order('parent_id','asc')
            ->order('sort_id','asc')
            ->select()
            ->toArray();
        $privilege = ArrayLib::getTree($p);
        $role = Db::name('role')
            ->where('is_delete',2)
            ->select()
            ->toArray();
        $ret = [
            'priData'   => $privilege,
            'data'      => $data,
            'hasPriArr' => $hasPriArr,
            'roleData'  => $role,


        ];

        return view('admin/role/edit', $ret);
    }
}