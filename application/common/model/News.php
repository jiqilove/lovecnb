<?php

namespace app\common\model;

use think\Model;

class  News extends Base
{
//    protected $autoWriteTimestamp =true;
//

    public function getNews($data = [])
    {
        $data ['status'] = [
            'neq', config('code.status_delete')];
        $order = ['id' => 'desc'];

        //下面这个是由tp5 提供的查询机制
        $result = $this->where($data)//查询语句
        ->order($order)//以id来排序
        ->paginate();//分页功能

//echo  $this->getLastSql();
//        return $result;
    }



    public function getNews1($data=[])
    {


        //下面这个是由tp5 提供的查询机制
        $result = $this->where($id)//查询语句
        ->select();
        return $result;
    }



    function pagination($obj)
    {
        if (!$obj) {
            return '';
        }
        $params = request()->param();
        return '<div class="imooc-app">' . $obj->appends($params)->render() . '</div>';


    }


    function getCatName($catId)
    {
        if (!$catId) {
            return '';
        }
        $cats = config('cat.lists');
        return !empty($cats[$catId]) ? $cats[$catId] : '';

    }

    /**
     *
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





}
