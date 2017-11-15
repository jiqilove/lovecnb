<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/25
 * Time: 15:40
 */

namespace app\common\lib;

class  Time
{
    /**
     * 获取时间戳
     * @return int
     */
public  static  function  get13TimeStamp()
{

    list($t1,$t2)=explode(' ',microtime());
    return $t2 .ceil($t1*1000);
}


}

