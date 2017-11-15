<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/10/23
 * Time: 20:26
 */

namespace app\common\lib\exception;
use think\Exception;


class  ApiException extends Exception
{

    public $message = '';
    public $httpCode = 500;
    public $code = 0;

    /**
     * ApiException constructor.
     * @param string $message
     * @param int $httpCode
     * @param string $code
     */
    public function __construct($message = '', $httpCode = 0, $code = '')
    {
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;


    }


}