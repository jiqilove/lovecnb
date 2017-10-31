<?php
namespace  app\common\validate;

use  think\Validate;
class  StudentsAdd extends  Validate {

protected  $rule = [
    'studentNum'  =>  'require|max:20',
    'password' => 'require|max:20',
    'phone'=>'require|length:11|number',
//    'email'=>'require|email',
];

}