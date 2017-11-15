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

class  Time extends Controller
{


    public function index()
    {

    return [time()];
    }



}