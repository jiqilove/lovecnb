<?php


namespace app\admin\controller;

use think\Controller;
use think\Request;

class VideosClass extends Base
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
         * 时间条件
         */
        if (!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time']) //    条件：开始时间、结束时间不能为空    结束时间大于开时间
        {
            $whereData ['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        /**
         * 标题搜索条件
         */
        if (!empty($data['class_name'])) {
            $whereData['class_name'] = ['like', '%' . $data['class_name'] . '%'];
        }




        $this->getPageAndSize($data);


        $videos_class = model('VideosClass')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('VideosClass')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'videos_cats' => config('cat.video_lists'),
            'videos' => $videos_class,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],

            'query' => $query,

        ]);
    }




    /**
     * 增加功能
     * @return mixed|
     */
    public function add()
{
    if (request()->isPost()) {
        $data = input("post.");
        //数据需要检验， validata 机制
        //入库操作

        try {
            $id = model('VideosClass')->add($data);

        } catch (\Exception $exception) {
            return $this->result($exception->getMessage(), 0, $exception->getMessage());
        }
        if ($id) {
            return $this->result(['jump_url' => url('videos_class/index')], 1, 'ok');
        } else {
            return $this->result('', 0, '新增失败');
        }

    } else {
        return $this->fetch('', [
            'videos_cats' => config('cat.video_lists')
        ]);
    }
}



    public function update(Request $request)
    {
//
        if (request()->isPost()) {
            $data = input("post.");
            $edit_id=$request->param('id');
//入库操作




            try {
                $id = model('VideosClass')
                    ->where('id', $edit_id)
                    ->update(
                        [
                            'class_name' => $data['class_name'],
                            'class_img' => $data['class_img'],
                            'videos_watch' => $data['videos_watch'],
                            'small_title' => $data['small_title'],
                            'content' => $data['content'],



                        ]
                    );

            } catch (\Exception $exception) {

                return $this->result('', 0, $exception->getMessage());
            }
            if ($id) {
                return $this->result(['jump_url' => url('videos_class/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败111');
            }


        }

        else {
            return $this->fetch('videos/index', [

            ]);
        }
    }





    public function videos_watch()
    {
//tp5 validata 机制 校验  id status
        $data = input('param.');
//        通过id 去库中查询下记录是否存在
        //model('News') ->get($data['id'])
        $model = $this->model ? $this->model : request()->controller();
//        echo  $model;

        try {
            $res = model($model)
                ->save(['videos_watch' => $data['videos_watch']], ['id' => $data['id']]);
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
