<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/10/23
 * Time: 20:26
 */

namespace app\api\controller;

use app\common\lib\Aes;
use think\Controller;
use app\common\lib\exception\ApiException;

class  Test extends Common
{


    public function index()
    {
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
    public function save()
    {
        //获取提交数据  插入库
        //给客户端APP =》插入数据
        $data = input('post.');

//        if ($data['age'] != 1) {
////   exception('你提交的数据不合法',400);
//            throw  new  ApiException('你提交的数据不合法', 400);
//        }
   return show(1, 'ok', (new  Aes())->encrypt(json_encode(input('post.'))), 201);
/**
 * 首先事通过aes  -》encrypt 进行加密
 * 因为加密只能是对字符串，所以必须将input 转换成字符串  就是利用json_encode
 */

    }


}