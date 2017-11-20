<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/25
 * Time: 15:40
 */

namespace app\common\lib;
//require VENDOR_PATH.'qiniu/php-sdk/autoload.php';

//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;


/**
 * 七牛云上传图片基类库
 * Class Upload
 * @package app\common\lib
 */
class  Upload
{


    public static function image()
    {

//        halt($_FILES['file']);
        if (empty($_FILES['file']['tmp_name'])) {
            exception('你提交的图片数据不合法', 404);
        }

        //要上传的文件的
        $file = $_FILES['file']['tmp_name'];

        //第一种获取文件名格式的方法
//        $ext = explode('.', $_FILES['file']['name']);
//        $ext = $ext[1];

        //第二种获取文件名格式的方法
        $pathinfo = pathinfo($_FILES['file']['name']);
        $ext = $pathinfo['extension'];

        $config = config('qiniu');
        //构建一个鉴权对象
        $auth = new Auth($config['ak'], $config['sk']);
        //生成上传的token
        $token = $auth->uploadToken($config['bucket']);
        //上传到七牛云后保存的文件名
        $key = date('Y') . "/" . date('m') . "/" .
            substr(md5($file), 0, 5) . date('YmdHis') .
            rand(0, 999) . "." . $ext;
        /**
         * Use of undefined constant YmdHis - assumed 'YmdHis'
         * 使用未定义的常数ymdhis假定的ymdhis”
         *  这句话的意思就是： 定义的常数不存在   然后你却存在这样的常数，那就说明了
         * 你缺少对这个常熟的一个引用
         */

//        halt($key);
// 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        list($res, $err) = $uploadMgr->putFile($token, $key, $file);

        if ($err != null) {
            return null;
        } else {

            return $key;
        }

//        halt($res);


        //构建一个鉴权对象
//          域名：  owyu9we9k.bkt.clouddn.com
//           ak ： 3uJuh7zmMGLGRzzds-neHdRv4mUkc53nVLBDiDzj
//           sk ：  HBxI3r24rHa3ALaGuFmgWE3UO8hQImkioDjEevYi

    }


}

