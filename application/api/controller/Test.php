<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/10/23
 * Time: 20:26
 */
namespace app\api\controller;

use think\Controller;

class  Test extends  Controller {


    public function  index(){
        return [
            'dddd',
            'dddddd',
        ];
    }

//    public  function  update($id=0){
////        echo $id;exit();
////        $id =input('put.id');
//
//        halt(input('put.'));
////        return $id;
//        //id dasta  -根据id去更新数据
//    }
//
//
    /**
     * post 新增
     * @return array
     */
    public function  save (){
        //获取提交数据  插入库
        //给客户端APP =》插入数据
         $data= [
            'status'=>1,
            'message'=>'ok',
             'data' =>input('post.')

        ];
         return json($data,201);
    }





}