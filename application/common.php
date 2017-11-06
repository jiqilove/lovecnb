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


//
//function getCatName($catId)
//{
//    if (!$catId) {
//        return '';
//    }
//    $cats = config('cat.lists');
//    return !empty($cats[$catId]) ? $cats[$catId] : '';
//
//}
//
//
//function isRecommend($recommend)
//{
//    //自己模仿上面的格式去写
////    if (!$recommend) {
////        return '';
////    }
////    $isrecommends = config('cat.recommend');
////    return !empty($isrecommends[$recommend]) ? $isrecommends[$recommend] : '';
//    /**
//     * 老师的代码：
//     * 由于是否推荐存在的是  1 和 0 的关系，所以直接使用 三元运算符 就可以解决问题
//     *
//     *
//     */
//
////    return $recommend ? '是':'否' ;  //不加样式
//    return $recommend ? '<span style ="color:red ;" >是  </span>' : '<span  style ="color:#666;"> 否</span>';
//
//}
//
//
///**
// * 根据id查找课程名字
// * @param $vclass  从index传过来的id
// * @return mixed
// *
// * 课程
// */
//function vclassName ($vclass){
//
//    $res = model('VideosClass')
//        ->where('id',$vclass)
//        ->column('class_name');
//
//    return $res[0];
//}
//
//function status($id, $status)
//{
//    $controller = request()->controller();
//
//    //获取控制器
//    $sta = $status == 1 ? 0 : 1;                    //最终修改的地址状态
//    $url =url($controller.'/status',['id'=>$id,'status'=>$sta]);
//    if($status ==1){
//        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      >
//<span  class ='label label-success radius '>正常</span></a>";
//    }else if  ($status ==0){
//        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>待审</span></a>";
//    }
//    return $str;
//
//}
//function isSlove($id, $is_solve)
//{
//    $controller = request()->controller();          //获取控制器
//
//    $sta = $is_solve == 1 ? 0 : 1;
//    //最终修改的地址状态
//    $url =url($controller.'/isSlove',['id'=>$id,'is_solve'=>$sta]);
//    if($is_solve ==1){
//        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-success radius '>已解决</span></a>";
//    }else if  ($is_solve ==0){
//        $str ="<a href='javascript:;' title='修改状态' status_url='".$url. " ' onclick='app_status(this)'      > <span  class ='label label-danger radius '>未解决</span></a>";
//    }
//    return $str;
//
//}
