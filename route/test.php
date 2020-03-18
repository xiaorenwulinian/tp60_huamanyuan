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





Route::group('/test', function(){
    Route::get('/', function () {
        return 'hello,ThinkPHP6!';
    });


    Route::any('validate/v1/test', 'test.validateTestV1/test');
    Route::any('validate/v2/test', 'test.validateTestV2/test');
    Route::any('validate/v3/test', 'test.validateTestV3/test');

    Route::any('db/v1/test', 'test.DbTestV1/test');

    Route::any('common/test', 'test.common/test');

    Route::any('upload/test', 'test.Upload/test');


});
