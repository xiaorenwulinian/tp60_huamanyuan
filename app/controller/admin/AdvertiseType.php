<?php

namespace app\controller\admin;


use app\common\tools\ArrayTool;
use app\common\tools\ExcelTool;
use think\facade\Db;
use think\facade\Route;

class AdvertiseType extends AdminBase
{
    /**
     * 列表
     * @return \think\response\View
     * @throws \think\db\exception\DbException
     */
   public function lst()
   {
       $pageSize = input('page_size', 10); // 每一页默认显示的条数
       $pageSizeSelect = page_size_select($pageSize); //生成下拉选择页数框
       $where = [];
       $name = input('name', ''); // 每一页默认显示的条数
       if (!empty($name)) {
           $where[] = ['name', 'like', "%{$name}%"];
       }
       $data = Db::table('advertise_type')->where($where)->order('sort_id','asc')->paginate($pageSize);
       $pageShow = $data->render();
       $ret = [
            'data'           => $data,
            'pageSizeSelect' => $pageSizeSelect,
            'pageSize'       => $pageSize,
            'pageShow'       => $pageShow,
       ];
       return view('admin/advertise_type/lst', $ret);
   }

    /**
     *  添加
     * @return \think\response\Json|\think\response\View
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $reqParam = $this->request->param();
            validate(\app\validate\AdvertiseTypeValidate::class)->scene('add')->check($reqParam);

            \app\model\AdvertiseType::create($reqParam);
            return success_response();
        }
        $ret = [

        ];
        return view('admin/advertise_type/add', $ret);

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
            validate(\app\validate\AdvertiseTypeValidate::class)->scene('edit')->check($reqParam);

            \app\model\AdvertiseType::where('id', $id)->update($reqParam);
            return success_response();
        }
        $data = Db::table('advertise_type')->find($id);
        $ret = [
            'data'       => $data,
        ];
        return view('admin/advertise_type/edit', $ret);
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
        $goodsCat = \app\model\GoodsCategory::where('id', $id)->find();
        $isShow   = $goodsCat->is_show == 1 ? 2 : 1;
        $goodsCat->is_show = $isShow;
        $goodsCat->save();
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
        \app\model\AdvertiseType::where('id','=', $id)->update(['sort_id' => $sortId ]);
        return success_response();
    }

    /**
     * 导出数据
     */
    public function exportData()
    {
        $reqParam = $this->request->param();
        $exportType = $reqParam['exportType'] ?? '';
        // 1.选中数据，2 所有数据
        if ($exportType == 1) {
            $ids = $this->request->param('id');
            $idArr = explode(',', $ids);
            $exportData = \app\model\AdvertiseType::whereIn('id', $idArr)->select()->toArray();

        } elseif ($exportType == 2) {
            $where = [];
            $name = $reqParam['name'] ?? '';
            if (!empty($name)) {
                $where[] = ['name', 'like', "%{$name}%"];
            }
            $exportData = \app\model\AdvertiseType::where($where)->select()->toArray();
        } else {
            return success_response();
        }
        $header = [
            'Id','名称','描述', '标识符'
        ];
        // 数组的每一列标题对应的字段
        $field = [
            'id','name','desc', 'identify_en'
        ];
        $file_name = '广告栏目'. date('YmdHis');
        ExcelTool::excelExport($exportData, $header, $field, $file_name);
    }
}
