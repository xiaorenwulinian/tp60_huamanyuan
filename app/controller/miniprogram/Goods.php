<?php

namespace app\controller\miniprogram;


use app\logic\GoodsLogic;
use app\model\Advertise;
use app\model\GoodsIntroduceImg;
use think\App;

class Goods extends MiniProgramBase
{
   public function __construct(App $app)
   {
       parent::__construct($app);
   }

   public function lst()
   {
       $goodsLogic = new GoodsLogic();
       $goodsData = $goodsLogic->goodsSearch();
       return success_response(compact('goodsData'));
   }

   public function detail()
   {
       $id = $this->request->param('goodsId');
       $goods = \app\model\Goods::find($id)->toArray();
//       $carouselArr = Advertise::where('adv_type_id','=',1)->field(['id', 'adv_img as img'])->select()->toArray();
       $carouselArr = [];
       $imgRootPath = $this->getImgRootPath();
//       foreach ($carouselArr as &$adv ) {
//           $adv['img'] = $imgRootPath . $adv['img'];
//       }

       $introduceImgArr = GoodsIntroduceImg::where('goods_id','=', $id)->select()->toArray();
       foreach ($introduceImgArr as &$v ) {
           $v['introduce_img'] = $imgRootPath . $v['introduce_img'];
       }
       $temp = [
         'id' => $goods['id'],
         'img' => $imgRootPath . $goods['goods_img'],
       ];
       array_push($carouselArr, $temp);
       $ret = [
           'goodsData' => $goods,
           'carouselImg' => $carouselArr,
           'introduceImg' => $introduceImgArr,
       ];
       return success_response($ret);

   }

    /**
     * 顶部轮播图
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function topCarousel()
    {
        $advertiseArr = Advertise::where('adv_type_id','=',1)->select()->toArray();
        $imgRootPath = $this->getImgRootPath();
        foreach ($advertiseArr as &$adv ) {
            $adv['adv_img'] = $imgRootPath . $adv['adv_img'];
        }
        return success_response(compact('advertiseArr'));
    }

    /**
     * 促销商品
     */
    public function promoteGoods()
    {
        $where = [
            ['is_delete', '=', 1],
        ];
        $promoteData = \app\model\Goods::where($where)->limit(4)->select();
        if (!empty($promoteData)) {
            $promoteArr = $promoteData->toArray();
        } else {
            $promoteArr = [];
        }
        $imgRootPath = $this->getImgRootPath();
        foreach ($promoteArr as &$v) {
            $v['goods_img'] = $imgRootPath . $v['goods_img'];
        }
        return success_response(compact('promoteArr'));

    }





}
