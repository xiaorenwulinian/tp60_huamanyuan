<?php

namespace app\controller\miniprogram;


use app\model\Advertise;
use think\App;

class Home extends MiniProgramBase
{
   public function __construct(App $app)
   {
       parent::__construct($app);
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

    /**
     * 首页商品列表,商品推荐
     */
   public function recommendGoods() {
       $curPage  = input('curPage', 1);
       $pageSize = input('pageSize', 2);
       $where = [];
       $where[] = ['is_delete', '=', 1];
       $goodsData = \app\model\Goods::where($where)->page($curPage, $pageSize)->select();
       if (!empty($goodsData)) {
           $recommendGoods = $goodsData->toArray();
       } else {
           $recommendGoods = [];
       }
       $imgRootPath = $this->getImgRootPath();
       foreach ($recommendGoods as &$v) {
           $v['goods_img'] = $imgRootPath . $v['goods_img'];
       }
       return success_response(compact('recommendGoods'));
   }



}
