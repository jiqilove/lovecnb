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
 * 获取栏目的名称
 * @param $catId
 * @return string
 */
function getCatName($catId)
{
    if (!$catId) {
        return '';
    }
    $cats = config('cat.lists');
    return !empty($cats[$catId]) ? $cats[$catId] : '';

}

/**
 *H
 * @param $catId
 * @return string
 *
 */
function getVideoCatName($catId)
{
    if (!$catId) {
        return '';
    }
    $cats = config('cat.video_lists');
    return !empty($cats[$catId]) ? $cats[$catId] : '';

}

function getAdminCatName($role)
{
    if (!$role) {
        return '';
    }
    $cats = config('cat.admin_lists');
    return !empty($cats[$role]) ? $cats[$role] : '';

}


function getSexCatName($sex)
{
    if (!$sex) {
        return '';
    }
    $cats = config('cat.sex_lists');
    return !empty($cats[$sex]) ? $cats[$sex] : '';

}


