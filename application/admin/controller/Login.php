<?php

namespace app\admin\controller;

use think\Controller;
use   app\common\lib\MyAuth;
use think\Request;


/**
 * 一般的常量都应该放到配置文件中去，
 * 也就是说在Android  中一般的常量不需要改变的量放到用一个类中，即 ---常量类---
 * Class Login
 * @package app\admin\controller
 */
class  Login extends Base
{

    public function _initialize()
    {

    }

    public function index()
    {//是否登录
        $isLogin = $this->isLogin();
        //如果已经登录，则跳转到index首页

        if ($isLogin) {
            //return 可加可不加，在这里 加了一个return 是为了代码的可读性，
            $this->redirect('index/index');
        } else {
            return $this->fetch();
        }

        //打印session值是否清除
        // halt(session(config('admin.session_user'))),''.config('admin.session_user_scope')

    }

    public function teacherLogin()
    {
        return $this->fetch();

    }

    public function adminLogin()
    {
        return $this->fetch();
    }

    public function studentsLogin()
    {
        return $this->fetch();

    }




    public function welcome()
    {
        return "hello api-admin";
    }

    /**
     * 登出
     */
    public function logout()
    {
//清空session
        session(null, config('admin.session_user_scope'));
        $this->redirect('login/index');
    }


    /**
     * 登陆相关业务
     * 1、检查验证码
     * 2、查看是否存在用户
     * 3、存在的用户的密码是否正确
     */
    public function check(Request $request)
    {
        $name = $request->param('login');
        $username = '';

        if ($name == 'Students') {
            $username = "studentNum";
        } else if ($name == 'Teachers') {
            $username = 'teacherNum';
        } else            if ($name == 'AdminUser') {
                $username = 'username';
            }
        dump($name);
        //检测是不是以  post的形式提交表单的
        if (request()->isPost()) {
            $data = input('post.');

            //垃圾验证码，关了关了

//            if (captcha_check($data['code'])) {
//                $this->error('验证码不正确');
//            }
            //判断username password  是否合法
            //使用 validata 机制
            /**
             * 1、username 去查询用户表
             * 2、username 去查询学生表
             * 3、username 去查询教师表
             * 2
             */

            try {
                $user = model($name)->get([$username => $data[$username]]);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            /**
             * !user : 如果输入的用户名在用户表里面不存在
             * $user->status!=1 : 状态为隐藏
             */
            if (!$user || $user->status != config('code.status_normal')) {
                $this->error('y用户不存在');
            }
            //再对密码进行校验~~~
            if (MyAuth:: setPassword($data['password']) != $user['password']) {
                $this->error('密码不正确');
            }
            // halt($user);
            /**
             * //1、更新数据库，登录时间 登录 ip
             */

            $udata = [
                'last_login_time' => time(),
                'last_login_ip' => $this->request->ip(),

            ];

            try {
                model($name)->save($udata, ['id' => $user->id]);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
            /**
             *   //2、 session
             */

            session(config('admin.session_user'), '$user', config('admin.session_user_scope'));


            if ($name == 'Students') {
                $this->success('登录成功', 'index/students');
            } else if ($name == 'Teachers') {
                $this->success('登录成功', 'index/index');
            } else            if ($name == 'AdminUser') {
                $this->success('登录成功', 'index/index');
            }



        } else {
            $this->error('请求不合法');

        }


//
//        if (captcha_check($data['code'])) {
//
//            $this->error('验证码不正确');
//
//        } else {
//            $this->success("ok");
//        }
    }


    public function select()
    {

    }

}