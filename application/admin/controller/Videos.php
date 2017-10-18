<?php


namespace app\admin\controller;

use think\Controller;
use think\Request;

class Videos extends Base
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
         * 栏目搜索条件
         */
        if (!empty($data['catid'])) {
            $whereData ['catid'] = intval($data['catid']);
        }
        /**
         * 标题搜索条件
         */
        if (!empty($data['title'])) {
            $whereData['title'] = ['like', '%' . $data['title'] . '%'];
        }


//获取数据 然后将数据填充到模板当中
        //模式一
//        $news =model('News')->getNews();
//        模式二
//        page size from limit from size
        $this->getPageAndSize($data);

//$whereData ['page']=$this ->page;
//$whereData ['size']= $this->size;


//        获取表里头的数据
        $videos = model('Videos')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('Videos')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'videos_cats' => config('cat.video_lists'),
            'videos' => $videos,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'catid' => empty($data['catid']) ? '' : $data['catid'],
            'title' => empty($data['title']) ? '' : $data['title'],
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
            $id = model('Videos')->add($data);

        } catch (\Exception $exception) {
            return $this->result('', 0, '新增失败');
        }
        if ($id) {
            return $this->result(['jump_url' => url('videos/index')], 1, 'ok');
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
//        dump($request);

        if (request()->isPost()) {
            $data = input("post.");
            $edit_id=$request->param('id');
//入库操作

            try {
                $id = model('Videos')
                    ->where('id', $edit_id)
                    ->update(
                        ['title' => $data['title'],
                            'small_title' => $data['small_title'],
                            'catid' => $data['catid'],
                            'description' => $data['description'],
                            'is_allowcomments' => $data['is_allowcomments'],
                            'is_position' => $data['is_position'],
                            'video' => $data['video'],
                            'content' => $data['content'],
                        ]
                    );

            } catch (\Exception $exception) {

                return $this->result('', 0, '修改失败');
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('videos/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败111');
            }


        }

        else {
            return $this->fetch('videos/index', [

            ]);
        }
    }





    public function welcome()
    {
        return "hello word";
    }
}
