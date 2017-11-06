<?php
/**
 * Created by PhpStorm.
 * User: cnb
 * Date: 2017/9/26
 * Time: 14:51
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class News extends Base
{

    public function index()
    {
//        $this ->model='News';
        $data = input('param.');
        /**
         * $query: 将一个数据作为一个url传送  然后在获取数据
         */
        $query = http_build_query($data);
//        halt($data);   //这句话测试 能都打印搜索到的时间的起止 类型 以及具体相关标题内容
        //转换查询条件
        $whereData = [];
        /**
         * 时间条件
         */
        if (!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time']) //    条件：开始时间、结束时间不能为空    结束时间大于开时间
        {
            $whereData ['create_time'] = [
                ['gt', strtotime($data['start_time'])],//时间戳
                ['lt', strtotime($data['end_time'])],
            ];
        }
        /**
         * 栏目搜索条件
         */
        if (!empty($data['catid'])) {
            $whereData ['catid'] = intval($data['catid']);
        }
        /**
         * 标题搜索条件
         */
        if (!empty($data['title'])) {
            $whereData['title'] = ['like', '%' . $data['title'] . '%'];
        }


//获取数据 然后将数据填充到模板当中
        //模式一
//        $news =model('News')->getNews();
//        模式二
//        page size from limit from size
        $this->getPageAndSize($data);



//        获取表里头的数据
        $data_admin = model('News')->getNewsByCondition($whereData, $this->from, $this->size);
//        halt($news);
        //一共有多少页
        $total = model('News')->getNewsCountByCondition($whereData);

//        echo  $total ;exit();
        //结合总数+size  =》 有多少页
        $pageTotal = ceil($total / $this->size);
        return $this->fetch('', [
            'cats' => config('cat.lists'),
            'news' => $data_admin,
            'pageTotal' => $pageTotal,
            'curr' => $this->page,
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'catid' => empty($data['catid']) ? '' : $data['catid'],
            'title' => empty($data['title']) ? '' : $data['title'],
            'query' => $query,

        ]);
    }

    public function update(Request $request)
    {


        if (request()->isPost()) {
            $data = input("post.");
            $edit_id=$request->param('id');

//入库操作
            try {
                $id = model('News')
                    ->where('id', $edit_id)
                    ->update(
                        ['title' => $data['title'],
                            'small_title' => $data['small_title'],
                            'catid' => $data['catid'],
                            'description' => $data['description'],
                            'is_allowcomments' => $data['is_allowcomments'],
                            'is_position' => $data['is_position'],
                            'image' => $data['image'],
                            'content' => $data['content'],
                        ]
                    );
            } catch (\Exception $exception) {
                return $this->result('', 0, '修改失败');
            }
            if (!empty($id)) {
                return $this->result(['jump_url' => url('news/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '修改失败111');
            }
        }

        else {
            return $this->fetch('news/index', [

            ]);
        }
    }

    /**
     *
     * 增加功能
     * @return mixed|void
     */
    public function add()
    {
        if (request()->isPost()) {
            $data = input("post.");
            //数据需要检验， validata 机制
//入库操作
            try {
                $id = model('News')->add($data);

            } catch (\Exception $exception) {
                return $this->result('', 0, '新增失败');
            }
            if ($id) {
                return $this->result(['jump_url' => url('news/index')], 1, 'ok');
            } else {
                return $this->result('', 0, '新增失败');
            }

        } else {
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }

    public function welcome()
    {
        return "hello word";
    }
}
