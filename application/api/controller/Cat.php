<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/11/15
 * Time: 9:44
 */

namespace app\api\controller;


class Cat extends Common
{

    public function index()
    {

        $cat = config('cat.lists');
        halt($cat);
    }

}