<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class VideosChapter extends Base
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
        if (!empty($data['chapter_name'])) {
            $whereData['chapter_name'] = ['like', '%' . $data['chapter_name'] . '%'];
        }


        $this->getPageAndSize($data);

//        获取表里头的数据
        $chapter = model('VideosChapter')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('VideosChapter')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [

            'videos' => $chapter,
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
        $classList = model('VideosClass')
            ->where('status', 1)
            ->column('class_name', 'id');
//返回以 id为索引的 name 列 数据

        if (request()->isPost()) {
            $data = input("post.");
            //数据需要检验， validata 机制
            //入库操作
            dump($data);
            try {
                $id = model('VideosChapter')->add($data);

            } catch (\Exception $exception) {
                return $this->result($exception->getMessage(), 0, $exception->getMessage());
            }
            if ($id) {
                return $this->result(['jump_url' => url('videos_chapter/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '新增失败');
            }

        } else {
            return $this->fetch('', [
                'className' => $classList,
            ]);
        }
    }


    public function update(Request $request)
    {
        if (request()->isPost()) {
            $data = input("post.");
            $edit_id = $request->param('id');
//入库操作
            try {
                $id = model('VideosChapter')
                    ->where('id', $edit_id)
                    ->update(
                        [   'videos_class_id' => $data['videos_class_id'],
                            'chapter_name' => $data['chapter_name'],
                            'chapter_watch' => $data['chapter_watch'],
                        ]
                    );
            } catch (\Exception $exception) {

                return $this->result('', 0, $exception->getMessage());
            }
            $getChapter_Name = Db::name('VideosChapter')->where('videos_class_id', $data['videos_class_id'])->column('chapter_name');
            $chaNanme = $data['chapter_name'];
            $long = sizeof($getChapter_Name);
            for ($i = 0; $i < $long; $i++) {
                if ($getChapter_Name[$i] = $chaNanme) {
                    return $this->result('', 0, '该课程下已经存在你所要创建的章节');
                    break;
                } else {
                    if ($id) {
                    } else {
                        return $this->result('', 0, '修改失败111');
                    }

                }
            }
        } else {
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

    public function chapter_watch()
    {
        $data = input('param.');
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)
                ->save(['chapter_watch' => $data['chapter_watch']], ['id' => $data['id']]);
        } catch (\Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }
        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');

        }
        return $this->result('', 0, '修改失败');


    }


}
