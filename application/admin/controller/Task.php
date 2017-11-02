<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Task extends Base
{

    /**
     * 首页查看
     * @return mixed
     */
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
         * 栏目搜索条件
         */
        if (!empty($data['college'])) {
            $whereData ['college'] = intval($data['college']);
        }


        if (!empty($data['major'])) {
            $whereData ['major'] = intval($data['major']);
        }


        /**
         * 标题搜索条件
         */
        if (!empty($data[''])) {
            $whereData['studentNum'] = ['like', '%' . $data['studentNum'] . '%'];
        }

        $this->getPageAndSize($data);

//        获取表里头的数据
        $tasks = model('Task')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('Task')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats_college' => config('cat.college_lists'),
            'collegeName1' => $this->getCollegeName(),
            'tasks' => $tasks,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'query' => $query,

        ]);
    }


    /**
     * 详情查看
     * @return mixed
     */
    public function details()
    {
        $data = input('param.');

        $id=$data['id'];
        dump($id);

        $query = http_build_query($data);
        $whereData = [];
        $this->getPageAndSize($data);


//        $detail=model('Task')
//            ->where('id',$id)
//        ->column('title');
//          dump($detail);


        $result = Db::view('Task','title,college_id,major_id,status,task_time')
            ->view('TaskQuestion',['difficulty_type'=>'difficulty_type','question','answer','img','id'],'TaskQuestion.task_id=task.id')
            ->where('task_id', $id)
            ->order('id desc')
            ->select();
//        dump($result);





//        获取表里头的数据
        $tasks = model('Task')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('Task')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats_college' => config('cat.college_lists'),
            'collegeName1' => $this->getCollegeName(),
            'task_details' => $result,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'query' => $query,

        ]);
    }


    /**
     * 增加功能
     * @return mixed|
     */

    public function add()
    {

        $stu_college = Db::name('College')
            ->where('status', '1')
            ->column('college_name', 'id');


        if (request()->isPost()) {
            $data = input("post.");


            try {
                $id = model('Task')->add($data);

            } catch (\Exception $exception) {

                return $this->result('', 0, $exception->getMessage());
            }
            if ($id) {
                return $this->result(['jump_url' => url('students/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '新增失败');
            }

        } else {

            return $this->fetch('', [
                'stu_cats_major' => config('cat.major_lists'),
                'stu_cats_college' => $stu_college,
                'cats_sex' => config('cat.sex_lists')
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

                $id = model('Task')
                    ->where('id', $edit_id)
                    ->update(
                        [
                            'title' => $data['title'],
                            'college_id' => $data['college_id'],
                            'major_id' => $data['major_id'],
                            'task_time' => $data['task_time'],

                        ]
                    );

            } catch (\Exception $exception) {

                return $this->result('', 0, $exception->getMessage());
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('task/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败');
            }


        } else {
            return $this->fetch('videos/index', [

            ]);
        }
    }


    public function getCollegeClassName($id)
    {
        $College = Db::name('CollegeClass')
            ->where('college_id', $id)
            ->column('	id,college_class_name');
        return json($College);
    }

    public function getCollegeName()
    {
        $stu_college = Db::name('College')
            ->where('status', '1')
            ->column('college_name', 'id');


        return $stu_college;
    }


    public function validateSutNum($data, $id)
    {

        try {
            $stu_num = model('Students')
                ->get(['studentNum' => $data['studentNum']]);
            $result = model('Students')
                // id 在 5到8之间的
                ->where('id', '<>', $id)
                ->column('studentNum');


        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }


        if (($stu_num == $result) == false) {
            $this->error('存在该学号');
        }

    }

    public function welcome()
    {
        return "hello word";
    }
}
