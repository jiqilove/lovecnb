<?php

namespace app\admin\controller;

use think\Controller;
use app\common\lib\Upload;
/**
 * 后台基类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    //分页的页数
    public $page = '';
    public $size = '';
    //查询条件的初始值
    public $from = 0;
    //定义model 获取控制的名称用的
    public $model = '';


    /**
     * 上传七妞云s
     */
    public function upload()
    {
        $dddd = Upload::image();
        if($dddd){

            $data = [
                'status' => 1,
                'message' => 'ok',
                'data' => config('qiniu.image_url').'/'.$dddd,
                //本地核域名之间的存在不同
                //
            ];
            echo json_encode($data);
        }else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }


    }





    /**
     * 初始化的方法
     */
    public function _initialize()
    {
//      判断用户是否登录

        $isLogin = $this->isLogin();
        if (!$isLogin) {
            echo 2;
            return $this->redirect('login/index');
        }
        //判断用户是否登录
    }

    public function isLogin()
    {
        //获取session
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));
        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * 获取分页的page size from 内容
     * @var page
     * @var size
     * @var from
     * @param $data
     */
    public function getPageAndSize($data)
    {

        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }


    /**删除功能逻辑
     * @param int $id
     */
    public function delete($id = 0)
    {

        $this_id=$id;

        if (!intval($this_id)) {
            return $this->result('', 0, 'id不合法');
        }

        //如果表和控制器文件名是一致 所以就可以使用  news  news
        //但是我们现在使用的这个表 和 控制器名是不一样的 所以要使用另外一个方法
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->save(['status' => -1], ['id' => $this_id]);

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
        $edit_id=$data['id'];

        $classList = model('VideosClass') ->where('status', 1) ->column('class_name', 'id');
        $model = $this->model ? $this->model : request()->controller();
        $contant = model($model)
            ->where('id', $edit_id)
            ->select();

        $task_time = model('Task') ->where('status', 1) ->column('title', 'id');

        return $this->fetch('',[

            'task_time' => $task_time,
            'className' => $classList,
            'cats' => config('cat.lists'),
            'stu_cats_college'=>config('cat.college_lists'),
            'stu_cats_major'=>config('cat.major_lists'),
            'cats_sex'=>config('cat.sex_lists'),
            'videos_cats' => config('cat.video_lists'),
            'contant' => $contant,

        ],[],[
            'id'=>$edit_id
        ]);
    }



    /**
     * 通用化修改状态
     *
     */
    public function status()
    {
//tp5 validata 机制 校验  id status
        $data = input('param.');
//        通过id 去库中查询下记录是否存在
        //model('News') ->get($data['id'])
        $model = $this->model ? $this->model : request()->controller();
//        echo  $model;

        try {
            $res = model($model)
                ->save(['status' => $data['status']], ['id' => $data['id']]);
        } catch (\Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }
        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');

        }
        return $this->result('', 0, '修改失败');


    }



}
