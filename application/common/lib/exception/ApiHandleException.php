<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/10/23
 * Time: 20:26
 */

namespace app\common\lib\exception;



use  think\exception\Handle;


class  ApiHandleException extends Handle
{
//在配置文件下（config。php）有一个异常处理类。       ‘’exception_handle=>''

    public $httpCode = 500;

    public function render(\Exception $e)
    {
        if(config('app_debug')==true){
            return parent::render($e);
        }

        if ($e instanceof ApiException)//如果$e  是ApiException  下的返回的异常  返回boolean
            $this->httpCode = $e->httpCode;

        return show(0, $e->getMessage(), [], $this->httpCode);


    }


}