<?php

namespace app\controller\admin;


use think\facade\Db;

class Advertise extends AdminBase
{
    /**
     * 列表
     * @return \think\response\View
     */
   public function lst()
   {
       $pageSize = input('page_size', 10); // 每一页默认显示的条数
       $pageSizeSelect = page_size_select($pageSize); //生成下拉选择页数框
       $data = \app\model\Advertise::search($pageSize);
       $pageShow = $data->render();
       $advType = \app\model\AdvertiseType::column('name', 'id');
       $ret = [
           'data'           => $data,
           'pageSizeSelect' => $pageSizeSelect,
           'pageSize'       => $pageSize,
           'pageShow'       => $pageShow,
           'advType'        => $advType,
       ];
       return view('admin/advertise/lst', $ret);
   }

    /**
     * 添加
     * @return \think\response\Json|\think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $reqParam = $this->request->param();
            validate(\app\validate\AdvertiseValidate::class)->scene('add')->check($reqParam);
            $advertise  = \app\model\Advertise::create($reqParam);
            return success_response();
        }
        $data = Db::table('advertise_type')->order('sort_id','asc')->select()->toArray();
        $ret = [
            'data' => $data
        ];
        return view('admin/advertise/add', $ret);
    }

    /**
     * 修改
     * @return \think\response\Json|\think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $id = $this->request->param('id');
        if ($this->request->isPost()) {

            $reqParam = $this->request->param();
            validate(\app\validate\AdvertiseValidate::class)->scene('edit')->check($reqParam);

            \app\model\Advertise::where('id', $id)->update($reqParam);
            return success_response();
        }
        $data = Db::table('advertise')->find($id);
        $advType = \app\model\AdvertiseType::column('name', 'id');

        $ret = [
            'data'    => $data,
            'advType' => $advType,
        ];
        return view('admin/advertise/edit', $ret);
    }

    /**
     * 删除或批量删除
     * @return \think\response\Json
     */
    public function delete()
    {
        $ids = $this->request->param('id');
        $idArr = explode(',', $ids);
        if (count($idArr) > 1) {
            return failed_response('不支持批量删除！');
        }
        \app\model\Advertise::whereIn('id', $idArr)->update(['is_delete' => 2]);
        return success_response();

    }

    /**
     * 修改显示状态
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function changeShow()
    {
        $id = $this->request->param('id');
        $data = \app\model\Advertise::where('id', $id)->find();
        $isShow   = $data->is_show == 1 ? 2 : 1;
        $data->is_show = $isShow;
        $data->save();
        return success_response();
    }


    /**
     * 修改排序
     * @return \think\response\Json
     */
    public function editSort()
    {
        $id = $this->request->param('id');
        $sortId = $this->request->param('sort_id');
        \app\model\Advertise::where('id','=', $id)->update(['sort_id' => $sortId ]);
        return success_response();
    }

}
