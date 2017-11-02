<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Vote extends Base
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
        if (!empty($data['content'])) {
            $whereData['content'] = ['like', '%' . $data['content'] . '%'];
        }

        $this->getPageAndSize($data);

//        获取表里头的数据
        $vote = model('Vote')->getNewsByCondition($whereData, $this->from, $this->size);
        //一共有多少页
        $total = model('Vote')->getNewsCountByCondition($whereData);



        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'vote' => $vote,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'query' => $query,
        ]);
    }



    public function isSlove()
    {
        $data = input('param.');
        $model = $this->model ? $this->model : request()->controller();
        try {
            $res = model($model)
                ->save(['is_solve' => $data['is_solve']], ['id' => $data['id']]);
        } catch (\Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }
        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        }
        return $this->result('', 0, '修改失败');
    }

    public function welcome()
    {
        return "hello word";
    }
}
