<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/11/13
 * Time: 20:26
 */

namespace app\api\controller;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use app\common\lib\MyAuth;
use app\common\lib\Time;
use think\Cache;
use think\Controller;


class  Common extends Controller
{
    public $headers = '';

    /**
     * 初始化的方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
//        $this->testAes();
    }

    /**
     * 检查每次App请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //首先是要获取headers
        $headers = request()->header();
        //sign   加密：客户端工程师   ，解密：服务端工程师
        //1、headers body 仿照sign 做参数的加密
        //2、变通 其他参数的加密
        //3、时间限制

        //基础的参数检验
        if (empty($headers['sign'])) {
            throw  new  ApiException('sign', '400');
        }
        if (!in_array($headers['app_type'], config('app.app_types'))) {
            throw  new  ApiException('类型不合法', '400');
        }
        //需要校验sign
        if (!MyAuth::checkSignPass($headers)) {
            throw  new ApiException('授权码sign 失败', 401);
        }
        //php处理的静态缓存
        Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));
        //1、文件  2、mysql  3、redis

        $this->headers = $headers;
    }


    public function testAes()
    {
        $data = [
            'aaa' => '11',
            'aaaa' => '11',
            'aa1a' => '11',
            'time' =>Time::get13TimeStamp(),
        ];

        /**
         * 加密
         */
//        MDEyMzQ1Njc4OWFiY2RlZm50T3hkMTRzUTVQUmh4SVhGM2dMQ1FzWUZ3aTBRVFJCU2NtUDd0OW83bitzcDhOOUZnYndaY2sxb0dLMDdJelM=
//        MDEyMzQ1Njc4OWFiY2RlZm50T3hkMTRzUTVQUmh4SVhGM2dMQ1ptQTJpYjZDcVAxdFBERXFZaVhBNFE9
        echo MyAuth::setSign($data);
        exit;
//        $str = 'id=1&name=ddd$ms=45';
////        MDEyMzQ1Njc4OWFiY2RlZk5LdytuaDhNbnVES0RkUXNEcENiTUpVUFFFdVdhc1RvR2xhR3lCUXVNNlE9
//        echo (new Aes())->encrypt($str);
//        exit;
//
        /**
         * 解密
         */
//        $aes_str='MDEyMzQ1Njc4OWFiY2RlZm50T3hkMTRzUTVQUmh4SVhGM2dMQ1FzWUZ3aTBRVFJCU2NtUDd0OW83bitzcDhOOUZnYndaY2sxb0dLMDdJelM=';
////        $aes_str='c2dnNDU3NDdzczIyMzQ1NVJmOUhIaVQ1VW5RRjFwKzgxYThjUmRRWUp1azYvdHBKYVYxL055NzVFbE09';
//        echo  (new Aes())->decrypt($aes_str);
//        exit;


    }


}