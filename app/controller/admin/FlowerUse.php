<?php

namespace app\controller\admin;


use think\facade\Db;

class FlowerUse extends AdminBase
{
    /**
     * 列表
     * @return \think\response\View
     */
   public function lst()
   {
       $pageSize = input('page_size', 10); // 每一页默认显示的条数
       $pageSizeSelect = page_size_select($pageSize); //生成下拉选择页数框
       $data = \app\model\FlowerUse::search($pageSize);
       $pageShow = $data->render();
       $ret = [
           'data'           => $data,
           'pageSizeSelect' => $pageSizeSelect,
           'pageSize'       => $pageSize,
           'pageShow'       => $pageShow,
       ];
       return view('admin/flower_use/lst', $ret);
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
            validate(\app\validate\FlowerUseValidate::class)->scene('add')->check($reqParam);
            \app\model\FlowerUse::create($reqParam);
            return success_response();
        }
        $ret = [
        ];
        return view('admin/flower_use/add', $ret);
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
            validate(\app\validate\FlowerUseValidate::class)->scene('edit')->check($reqParam);
            \app\model\FlowerUse::where('id', $id)->update($reqParam);
            return success_response();
        }
        $data = Db::table('flower_use')->find($id);
        $ret = [
            'data' => $data,
        ];
        return view('admin/flower_use/edit', $ret);
    }


    /**
     * 修改排序
     * @return \think\response\Json
     */
    public function editSort()
    {
        $id = $this->request->param('id');
        $sortId = $this->request->param('sort_id');
        \app\model\FlowerUse::where('id','=', $id)->update(['sort_id' => $sortId ]);
        return success_response();
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
        \app\model\FlowerUse::whereIn('id', $idArr)->update(['is_delete' => 2]);
        return success_response();

    }


}
