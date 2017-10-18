<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/26
 * Time: 15:39
 */

namespace app\admin\controller;


use think\Request;
use app\common\lib\Upload;

/** 后台上传图片相关逻辑
 * Class Image
 * @package app\admin\controller
 */
class Image extends Base
{
    /**
     * 上传七妞云
     */
    public function upload()
    {

        try {
            $image = Upload::image();
        }catch (\Exception $exception){
            echo json_encode(['status' => 0, 'message' => $exception->getMessage()]);
        }
        if($image){

            $data = [
                'status' => 1,
                'message' => 'ok',
            'data' => config('qiniu.image_url').'/'.$image,
                //本地核域名之间的存在不同
                //
            ];
            echo json_encode($data);
        }else {
            echo json_encode(['status' => 0, 'message' => '上传失败']);
        }


    }


    /**
     * 图片上传本地
     */
    public function upload0()
    {
        $file = Request::instance()->file('file');
        //把图片上传到指定的文件夹
        $info = $file->move('upload');

//        halt($info);
//        $str=$info->getPathname();
//        $str1=var_export(str_replace('\\','/',$str));
        if ($info && $info->getPathname()) {

            $data = [
                'status' => 1,
                'message' => 'ok',
//                'data' => 'http://img01.sogoucdn.com/app/a/100520024/d5ae4f5f8983527b89f095fa8f9e03ff',
                'data' => '/lovecnb/public/' . $info->getPathname(),
                //本地核域名之间的存在不同
                //
            ];
            echo json_encode($data);
            exit;
        }
        echo json_encode(['status' => 0, 'message' => '上传失败']);
    }

}



//        $data = [
//                'status' => 1,
//                'message' => 'ok',
//                'data' => 'http://img01.sogoucdn.com/app/a/100520024/d5ae4f5f8983527b89f095fa8f9e03ff',
//            ];
//
//            echo json_encode($data);
