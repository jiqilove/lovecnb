<?php
namespace app\common\model;

use think\Model;
class  Base extends  Model {
    protected $autoWriteTimestamp =true;

    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function  add ($data){


        if(!is_array($data)){
            exception('传递数据不合法');
        }

        $this ->allowField(true) ->save($data);

        return $this ->id;
    }


    /**
     * 获取表里头的数据
     * @param array $condition
     * @param int $from
     * @param int $size
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getNewsByCondition($condition=[],$from=0,$size=5)
    {

        $condition ['status'] = [
            'neq', config('code.status_delete')];

        $order = ['id' => 'desc'];
//        $from = ($param['page'] - 1) * $param['size'];

        $result = $this->where($condition)
            ->limit($from, $size)
            ->order($order)
            ->select();
        echo  $this->getLastSql();
        return $result;
    }




    /**
     * 根据条件来获取列表数据的总数
     * @param array $param
     * @return int|string
     */
    public function getNewsCountByCondition($condition = [])
    {
        $condition ['status'] = [
            'neq', config('code.status_delete')
        ];
        $result = $this->where($condition)
            ->count();
        return $result;
//                echo  $this->getLastSql();   // 打印数据库语句
    }





//
//    public function  up_date ($data )
//    {
//
//        if(!is_array($data)){
//            exception('传递数据不合法');
//        }
//
//        $this ->allowField(true) ->update($data);
//
//
//
//
//    }

}
