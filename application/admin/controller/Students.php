<?php


namespace app\admin\controller;

use think\Controller;
use think\Request;

class Students extends Base
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
        /**
         * 标题搜索条件
         */
        if (!empty($data['studentNum'])) {
            $whereData['studentNum'] = ['like', '%' . $data['studentNum'] . '%'];
        }

        $this->getPageAndSize($data);

//        获取表里头的数据
        $student = model('Students')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('Students')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats_college' => config('cat.college_lists'),

            'students' => $student,
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

    if (request()->isPost()) {
        $data = input("post.");
                $validate = validate('StudentsAdd');
        if (!$validate->check($data)) {
            $this->error($validate->getError());
        }

        $data['password'] = md5($data['password'] . '_#sing_ty');
        $data ['status'] = 1;
        try {
            $id = model('Students')->add($data);

        } catch (\Exception $exception) {

            return $this->result('', 0, '新增失败');
        }
        if ($id) {
            return $this->result(['jump_url' => url('students/index')], 1, 'ok');
        } else {
            return $this->result('', 0, '新增失败');
        }

    } else {

        return $this->fetch('', [
            'stu_cats_major' => config('cat.major_lists'),
            'stu_cats_college' => config('cat.college_lists'),
            'cats_sex' => config('cat.sex_lists')
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

                $id = model('Students')
                    ->where('id', $edit_id)
                    ->update(
                        [
                            'studentNum' => $data['studentNum'],
                            'stu_img' => $data['stu_img'],
                            'stu_name' => $data['stu_name'],
                            'password' => $data['password'] = md5($data['password'] . '_#sing_ty'),
                            'college' => $data['college'],
                            'major' => $data['major'],
                            'sex' => $data['sex'],
                            'birthday' => $data['birthday'],
                            'phone' => $data['phone'],
                            'email' => $data['email'],
                            'address' => $data['address'],
                        ]
                    );

            } catch (\Exception $exception) {

                return $this->result('', 0, '修改失败');
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('students/index')], 1, 'ok');
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
