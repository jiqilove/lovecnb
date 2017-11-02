<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Comment extends Base
{


    public function index()
    {

        $data = input('param.');
        /**
         * $query: 将一个数据作为一个url传送  然后在获取数据
         */
        $query = http_build_query($data);
//        halt($data);   //这句话测试 能都打印搜索到的时间的起止 类型 以及具体相关标题内容
        //转换查询条件
        $whereData = [];


        /**
         * 标题搜索条件
         */
        if (!empty($data['students_id'])) {
            $whereData['students_id'] = ['like', '%' . $data['students_id'] . '%'];
        }

        $this->getPageAndSize($data);

//        获取表里头的数据
        $comment = model('Comment')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);

        //一共有多少页
        $total = model('Comment')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'comments' => $comment,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'query' => $query,

        ]);
    }



    public function welcome()
    {
        return "hello word";
    }
}
