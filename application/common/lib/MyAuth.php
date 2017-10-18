<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/25
 * Time: 15:40
 */

namespace  app\common\lib;

class  MyAuth {


    public  static  function  setPassword ($data){
        return md5($data .config('app.password_pre_halt')) ;
    }

}

