<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/11/15
 * Time: 9:44
 */

namespace app\api\controller\v1;
use think\Controller;
use app\api\controller\Common;
class Cat extends Common
{

    public function read()
    {

        $cat = config('cat.lists');

        $result[]=[
            'catid'=>0,
            'catname'=>'首页'
        ];
        /**
         * foreach 使用来遍历一个数组里头的数据， * 这里的用法就是
         * 遍历$cat  这个数组下的数据，
         * $catid  键 -----》$catnaame 值
         * 以键值对的形式保存下来
         */
        foreach ($cat as $catid =>$catname){

            $result[]=[
                'catid'=>$catid,
                'catname'=>$catname
            ];
        }


        return  show(config('app.success'),'ok',$result,200);
    }

}