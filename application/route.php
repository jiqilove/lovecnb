<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//get

Route::get('test','api/test/index');

Route::put('test/:id','api/test/update');//修改
Route::delete('test/:id','api/test/delete');//删除


//Route::resource();
Route::resource('test','api/test');
//   对应路径  x.com/test   post=>api test save

Route::get('api/:ver/cat','api/:ver.cat/read');