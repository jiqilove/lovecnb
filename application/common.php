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

// 应用公共文件

function pagination($obj)
{
    if (!$obj) {
        return '';
    }
    $params = request()->param();
    return '<div class="imooc-app">' . $obj->appends($params)->render() . '</div>';


}

/**
 * 获取栏目的名称
 * @param $catId
 */
function getCatName($catId)
{
    if (!$catId) {
        return '';
    }
    $cats = config('cat.lists');
    return !empty($cats[$catId]) ? $cats[$catId] : '';

}

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


function getMajorCatName($major)
{
    if (!$major) {
        return '';
    }
    $cats = config('cat.major_lists');
    return !empty($cats[$major]) ? $cats[$major] : '';

}

function getCollegeCatName($college)
{
    if (!$college) {
        return '';
    }
    $cats = config('cat.college_lists');
    return !empty($cats[$college]) ? $cats[$college] : '';

}


function getSexCatName($sex)
{
    if (!$sex) {
        return '';
    }
    $cats = config('cat.sex_lists');
    return !empty($cats[$sex]) ? $cats[$sex] : '';

}




function vclassName ($vclass){

    $res = model('VideosClass')
        ->where('id',$vclass)
        ->column('class_name');

return $res[0];
}


function vChapterName ($vchapter){

    $res = model('VideosChapter')
        ->where('id',$vchapter)
        ->column('chapter_name');

    return $res[0];
}




/**
 * 是否推荐
 *
 */
function isRecommend($recommend)
{
    //自己模仿上面的格式去写
//    if (!$recommend) {
//        return '';
//    }
//    $isrecommends = config('cat.recommend');
//    return !empty($isrecommends[$recommend]) ? $isrecommends[$recommend] : '';
    /**
     * 老师的代码：
     * 由于是否推荐存在的是  1 和 0 的关系，所以直接使用 三元运算符 就可以解决问题
     *
     *
     */

//    return $recommend ? '是':'否' ;  //不加样式
    return $recommend ? '<span style ="color:red ;" >是  </span>' : '<span  style ="color:#666;"> 否</span>';

}
/**
 * 状态
 * 待审/发布
 * @param $id
 * @param $status
 * @return string
 */
function status($id, $status)
{
    $controller = request()->controller();

    //获取控制器
    $sta = $status == 1 ? 0 : 1;                    //最终修改的地址状态
    $url =url($controller.'/status',['id'=>$id,'status'=>$sta]);
    if($status ==1){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > 
<span  class ='label label-success radius '>正常</span></a>";
    }else if  ($status ==0){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>待审</span></a>";
    }
    return $str;

}


/**
 * 状态
 * 待审/发布
 * @param $id
 * @param $status
 * @return string
 */
function upload_status($id, $upload_status)
{
    $controller = request()->controller();          //获取控制器
    $sta = $upload_status == 1 ? 0 : 1;                    //最终修改的地址状态
    $url =url($controller.'/upload_status',['id'=>$id,'upload_status'=>$sta]);
    if($upload_status ==1){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-success radius '>允许上传</span></a>";
    }else if  ($upload_status ==0){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>没有权限</span></a>";
    }
    return $str;

}


function manager_status($id, $manager_status)
{
    $controller = request()->controller();          //获取控制器

    $sta = $manager_status == 1 ? 0 : 1;
  //最终修改的地址状态
    $url =url($controller.'/manager_status',['id'=>$id,'manager_status'=>$sta]);
    if($manager_status ==1){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-success radius '>允许管理</span></a>";
    }else if  ($manager_status ==0){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>没有权限</span></a>";
    }
    return $str;

}

function videos_watch($id, $videos_watch)
{
    $controller = request()->controller();          //获取控制器

    $sta = $videos_watch == 1 ? 0 : 1;
    //最终修改的地址状态
    $url =url($controller.'/videos_watch',['id'=>$id,'videos_watch'=>$sta]);
    if($videos_watch ==1){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-success radius '>允许观看</span></a>";
    }else if  ($videos_watch ==0){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>未可观看</span></a>";
    }
    return $str;

}
function chapter_watch($id, $chapter_watch)
{
    $controller = request()->controller();          //获取控制器

    $sta = $chapter_watch == 1 ? 0 : 1;
    //最终修改的地址状态
    $url =url($controller.'/chapter_watch',['id'=>$id,'chapter_watch'=>$sta]);
    if($chapter_watch ==1){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-success radius '>允许观看</span></a>";
    }else if  ($chapter_watch ==0){
        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>未可观看</span></a>";
    }
    return $str;

}
