<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/25
 * Time: 15:44
 */
return [
//密码加密
    'password_pre_halt' =>'_#sing_ty',
    'aes_key'=>'0123456789abcdef',//aes  密钥，服务端核客户端必须保持一直
    'app_types'=>[
        'ios','Android',
    ],
    'app_sign_time'=>600000,//sign失效时间
    'app_sign_cache_time'=>1200,//sign缓存失效时间
];