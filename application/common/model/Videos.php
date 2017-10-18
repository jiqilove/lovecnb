<?php

namespace app\common\model;

use think\Model;

class  Videos extends Base
{
//    protected $autoWriteTimestamp =true;
//

    public function getNews($data = [])
    {
        $data ['status'] = [
            'neq', config('code.status_delete')];
        $order = ['id' => 'desc'];

        //下面这个是由tp5 提供的查询机制
        $result = $this->where($data)//查询语句
        ->order($order)//以id来排序
        ->paginate();//分页功能

//echo  $this->getLastSql();
//        return $result;
    }











}
