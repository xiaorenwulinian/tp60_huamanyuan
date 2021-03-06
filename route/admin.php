<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;




Route::group('/admin', function(){
    Route::group('', function () {
        Route::get('test', function () {
            return 'hello,admin!';
        });
        Route::get('', 'admin.Index/index');
        Route::get('index/mainContent', 'admin.Index/mainContent');

        Route::group('goodsCategory', function () {
            Route::get('lst', 'admin.GoodsCategory/lst');
        });

    })->middleware([app\middleware\AdminAuthCheck::class]);

    Route::group('privilege', function () {
        Route::get('lst', 'admin.privilege/lst');
        Route::any('add', 'admin.privilege/add');
        Route::any('edit', 'admin.privilege/edit');
        Route::any('changeShow', 'admin.privilege/changeShow');
        Route::any('changeMenu', 'admin.privilege/changeMenu');
//        Route::any('delete', 'admin.privilege/delete');
        Route::any('editSort', 'admin.privilege/editSort');
    });

    Route::group('role', function () {
        Route::get('privilegeByRoleId', 'admin.role/privilegeByRoleId');
        Route::get('lst', 'admin.role/lst');
        Route::any('add', 'admin.role/add');
        Route::any('edit', 'admin.role/edit');
        Route::any('changeShow', 'admin.role/changeShow');
//        Route::any('delete', 'admin.role/delete');
        Route::any('editSort', 'admin.role/editSort');
    });

    // 商品分类，暂未使用
    Route::group('goodsCategory', function () {
        Route::get('lst', 'admin.GoodsCategory/lst');
        Route::any('add', 'admin.GoodsCategory/add');
        Route::any('edit', 'admin.GoodsCategory/edit');
        Route::any('changeShow', 'admin.GoodsCategory/changeShow');
        Route::any('delete', 'admin.GoodsCategory/delete');
        Route::any('editSort', 'admin.GoodsCategory/editSort');
    });


    // 广告分类
    Route::group('advertiseType', function () {
        Route::get('lst', 'admin.AdvertiseType/lst');
        Route::any('add', 'admin.AdvertiseType/add');
        Route::any('edit', 'admin.AdvertiseType/edit');
        Route::any('changeShow', 'admin.AdvertiseType/changeShow');
        Route::any('delete', 'admin.AdvertiseType/delete');
        Route::any('editSort', 'admin.AdvertiseType/editSort');
        Route::any('exportData', 'admin.AdvertiseType/exportData');
    });

    // 广告
    Route::group('advertise', function () {
        Route::get('lst', 'admin.Advertise/lst');
        Route::any('add', 'admin.Advertise/add');
        Route::any('edit', 'admin.Advertise/edit');
        Route::any('changeShow', 'admin.Advertise/changeShow');
        Route::any('delete', 'admin.Advertise/delete');
        Route::any('editSort', 'admin.Advertise/editSort');
        Route::any('exportData', 'admin.Advertise/exportData');
    });

    // 鲜花用途
    Route::group('flowerUse', function () {
        Route::get('lst', 'admin.FlowerUse/lst');
        Route::any('add', 'admin.FlowerUse/add');
        Route::any('edit', 'admin.FlowerUse/edit');
        Route::any('changeShow', 'admin.FlowerUse/changeShow');
        Route::any('delete', 'admin.FlowerUse/delete');
        Route::any('editSort', 'admin.FlowerUse/editSort');
    });

    // 鲜花花材
    Route::group('flowerMaterial', function () {
        Route::get('lst', 'admin.FlowerMaterial/lst');
        Route::any('add', 'admin.FlowerMaterial/add');
        Route::any('edit', 'admin.FlowerMaterial/edit');
        Route::any('changeShow', 'admin.FlowerMaterial/changeShow');
        Route::any('delete', 'admin.FlowerMaterial/delete');
        Route::any('editSort', 'admin.FlowerMaterial/editSort');
        Route::any('exportData', 'admin.FlowerMaterial/exportData');
    });

    // 商品
    Route::group('goods', function () {
        Route::get('lst', 'admin.Goods/lst');
        Route::any('add', 'admin.Goods/add');
        Route::any('edit', 'admin.Goods/edit');
        Route::any('changeShow', 'admin.Goods/changeShow');
        Route::any('delete', 'admin.Goods/delete');
        Route::any('editSort', 'admin.Goods/editSort');
        Route::any('exportData', 'admin.Goods/exportData');
        Route::any('editMultiFileDelete', 'admin.Goods/editMultiFileDelete');
    });

    Route::group('common', function () {
        Route::any('addUpload', 'admin.Common/addUpload');  // 添加时上传文件
        Route::any('addMultiUpload', 'admin.Common/addMultiUpload');  // 添加时上传文件
        Route::any('editUpload', 'admin.Common/editUpload');  // 修改时上传文件
        Route::any('addDeleteFile', 'admin.Common/addDeleteFile'); // 添加时删除文件
    });



    Route::any('login/login', 'admin.Login/login');

    Route::get('login/logout', 'admin.Login/logout');
    Route::get('login/verify', 'admin.Login/verify');

})->middleware([think\middleware\SessionInit::class]);



