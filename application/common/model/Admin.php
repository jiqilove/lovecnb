<?php
namespace app\common\model;

use think\Model;
class  Admin extends  Base
{
    protected $autoWriteTimestamp = true;

    /**
     * 新增
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        $this ->model='AdminUser';
        $model = $this->model ? $this->model : request()->controller();

        if (!is_array($data)) {
            exception('传递数据不合法');
        }

        try {
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        } catch (\Exception $exception) {
            return $this->result('', 0, $exception->getMessage());
        }
        if ($res) {
            return $this->result(['jump_url' => $_SERVER['HTTP_REFERER']], 1, 'OK');

        }
        return $this->result('', 0, '删除失败');

    }
}
