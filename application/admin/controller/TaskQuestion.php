<?php


namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class TaskQuestion extends Base
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
        if (!empty($data['studentNum'])) {
            $whereData['studentNum'] = ['like', '%' . $data['studentNum'] . '%'];
        }

        $this->getPageAndSize($data);

//        获取表里头的数据
        $taskquestion = model('TaskQuestion')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('TaskQuestion')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats_college' => config('cat.college_lists'),

            'task_question' => $taskquestion,
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

    $task_time=Db::name('Task')
        ->where('status','1')
        ->column('title','id');
    dump($task_time);
    $string=implode('-',$task_time);
dump($string);
    if (request()->isPost()) {
        $data = input("post.");
        try {
            $id = model('TaskQuestion')->add($data);

        } catch (\Exception $exception) {

            return $this->result('', 0, $exception->getMessage());
        }
        if ($id) {
            return $this->result(['jump_url' => url('task_question/index')], 1, 'ok');
        } else {
            return $this->result('', 0, '新增失败');
        }

    } else {

        return $this->fetch('', [
            'task_time' =>$task_time
                  ]);
    }
}



    public function update(Request $request)
    {
        if (request()->isPost()) {
            $data = input("post.");
            $edit_id=$request->param('id');

//入库操作

            try {

                $id = model('TaskQuestion')
                    ->where('id', $edit_id)
                    ->update(
                        [
                            'difficulty_type' => $data['difficulty_type'],
                            'question' => $data['question'],
                            'answer' => $data['answer'],
                            'task_id' => $data['task_id'] ,


                        ]
                    );

            } catch (\Exception $exception) {

                return $this->result('', 0, $exception->getMessage());
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('task_question/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败111');
            }


        }

        else {
            return $this->fetch('videos/index', [

            ]);
        }
    }


    public function getCollegeClassName($id){
        $College = Db::name('CollegeClass')
            ->where('college_id',$id)
            ->column('	id,college_class_name');
        return json($College);
    }

    public function  getCollegeName (){
        $stu_college=Db::name('College')
            ->where('status','1')
            ->column('college_name', 'id');


        return $stu_college;
    }



    public function   validateSutNum($data,$id){

        try {   $stu_num=model('Students')
            ->get(['studentNum'=>$data['studentNum']]);
            $result = model('Students')
                // id 在 5到8之间的
                ->where('id', '<>', $id)
                ->column('studentNum');


        }catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }


        if(($stu_num==$result)==false){
            $this->error('存在该学号');
        }

    }
    public function welcome()
    {
        return "hello word";
    }
}
