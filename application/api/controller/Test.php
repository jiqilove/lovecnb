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

    public  function  update($id=0){
//        echo $id;exit();
//        $id =input('put.id');

        halt(input('put.'));
//        return $id;
        //id dasta  -根据id去更新数据
    }

}