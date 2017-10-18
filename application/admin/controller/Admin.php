<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class  Admin extends Base
{
//<input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
//    -
//        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">


    public $modle1 = 'AdminUser';

    public function index()
    {

        $this->model = 'AdminUser';
        $data = input('param.');

        $whereData = [];
        /**
         * $query: 将一个数据作为一个url传送  然后在获取数据
         */
        $query = http_build_query($data);
//        halt($data);   //这句话测试 能都打印搜索到的时间的起止 类型 以及具体相关标题内容
        //转换查询条件

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
        if (!empty($data['role'])) {
            $whereData ['role'] = intval($data['role']);
        }
        /**
         * 标题搜索条件
         */
        if (!empty($data['title'])) {
            $whereData['title'] = ['like', '%' . $data['title'] . '%'];
        }

        $this->getPageAndSize($data);
//        获取表里头的数据
        $news = model('Admin_user')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('Admin_user')->getNewsCountByCondition($whereData);

        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);

        return $this->fetch('', [
            'admin_cats' => config('cat.admin_lists'),
            'admins' => $news,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'query' => $query,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'role' => empty($data['role']) ? '' : $data['role'],
            'title' => empty($data['title']) ? '' : $data['title'],
        ]);
    }


    public function add()
    {


        //判断是否使用post提交
        if (request()->isPost()) {
            //打印提交的数据

            $data = input('post.');

            //validate机制
            $validate = validate('AdminUser');
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }
            $data['password'] = md5($data['password'] . '_#sing_ty');
            $data ['status'] = 1;
            // 1

            try {
                $id = model('AdminUser')->add($data);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage() . '');

            }

            if ($id) {
                $this->success('id=' . $id . 'the username add success');
            } else {
                $this->success('id=' . $id . 'the username add unsuccessful');
            }


        } else {

            return $this->fetch('',[
                'role'=>config('cat.admin_lists')

            ]);

        }


    }


    public function delete($id = 0)
    {

        if (!intval($id)) {
            return $this->result('', 0, 'id不合法');
        }
        //如果表和控制器文件名是一致 所以就可以使用  news  news
        //但是我们现在使用的这个表 和 控制器名是不一样的 所以要使用另外一个方法
        $model = $this->modle1 ? $this->modle1 : request()->controller();
        try {
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        } catch (\Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }
        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');

        }
        return $this->result('', 0, '删除失败');
    }


    /**
     * 修改功能
     *
     */
    public function edit()
    {
        $data = input('param.');
        dump($data);
        echo $data['id'];
        $edit_id = $data['id'];
        $model = $this->modle1 ? $this->modle1 : request()->controller();


        $contant = model($model)
            ->where('id', $data['id'])
            ->select();

//        $good = $contant[0];// 获取具体的array 数组内容
        return $this->fetch('', [
            'role' => config('cat.admin_lists'),
            'contant' => $contant,
            'id' => $edit_id

        ], [], [
            'id' => $edit_id
        ]);
    }


    public function update(Request $request)
    {


        if (request()->isPost()) {
            $data = input("post.");
            $edit_id = $request->param('id');


//入库操作
            try {
                $id = model('AdminUser')
                    ->where('id', $edit_id)
                    ->update(
                        ['username' => $data['username'],
                            'password' => $data['password'] = md5($data['password'] . '_#sing_ty'),
                            'phone' => $data['phone'],
                            'role' => $data['role'],
                            'email' => $data['email'],
                        ]
                    );


            } catch (\Exception $exception) {
                return $this->result('', 0, '修改失败');
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('admin/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败111');
            }
        } else {
            return $this->fetch('admin/index', [

            ]);
        }
    }


}