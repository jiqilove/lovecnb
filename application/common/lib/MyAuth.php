<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/25
 * Time: 15:40
 */

namespace app\common\lib;

use think\Cache;

class  MyAuth
{


    public static function setPassword($data)
    {
        return md5($data . config('app.password_pre_halt'));
    }


    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data =[])
    {
        //1、按字母排序
        ksort($data);
        // 2、字符串的拼接
        $string = http_build_query($data); //这里的意思就是将数组转换成   &  & 形式，然后用字符串拼接起来
        //3、通过 aes加密
        $string =  (new  Aes())->encrypt($string);
//        //4、所有字符转成大写
//        $string = strtoupper($string);

    return $string;
    }


    /**
     * 检查sign是否正常
     * @param string $sign
     * @param $data
     * @return bool
     */
    public  static  function  checkSignPass($data){
        $str=(new Aes())->decrypt($data['sign']);
        if(empty($str)){
            return false;
        }

        parse_str($str,$arr);

//在提交表单的时候有多少需要验证的就填进来
        if (!is_array($arr) || empty($arr['aaa'] )  ){
            return false;
        }
        /**
         * 时间判断
         * 如果超过时间的话就不能通过
         *  但是这个设定并不是万能的，黑客有在获取到sign并且在你设顶的时间之内去登陆
         */
        if ((time()-ceil($arr['time']/1000 )  )>config('app.app_sign_time')){
            return false;
        }
        /**
         * 唯一性判断
         *  echo Cache::get($data['sign']);
         */
        if(Cache::get($data['sign'])){
            return false;
        }

return true;
    }

}

