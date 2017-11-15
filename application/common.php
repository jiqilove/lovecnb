<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;

// 应用公共文件
/**
 * 分页显示
 * @param $obj
 * @return string
 */


function pagination($obj)
{
    if (!$obj) {
        return '';
    }
    $params = request()->param();
    return '<div class="imooc-app">' . $obj->appends($params)->render() . '</div>';


}

/**
 *  通用化接口API 数据输出
 * @param $status       业务状态码
 * @param $message      信息提示
 * @param $data         数据
 * @param $httpCode     http状态码
 * @return array
 */
function show($status, $message, $data=[], $httpCode)
{

    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
return json($data,$httpCode);
}