<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;


/**
 * 根据id查找课程名字
 * @param $vclass  从index传过来的id
 * @return mixed *
 */
function vclassName ($vclass){
    $res = model('VideosClass')
        ->where('id',$vclass)
        ->column('class_name');
    return $res[0];
}


/**
 * 根据id查找章节名字
 * @param $vchapter 从index传过来的id
 * @return mixed
 *
 * 章节
 */
function vChapterName ($vchapter){

    $res = model('VideosChapter')
        ->where('id',$vchapter)
        ->column('chapter_name');

    return $res[0];
}


/**
 *  根据id查找学院 名字
 * @param $college  从index传过来的id
 * @return mixed
 *
 * 学院
 */
function scollege ($college){

    $res = Db::name('College')
        ->where('id',$college)
        ->column('college_name');

    return $res[0];
}


/**
 * 根据id查找专业 名字
 * @param $major 从index传过来的id
 * @return mixed
 *
 *
 * 专业
 */

function smajor ($major){
    $res = Db::name('CollegeClass')
        ->where('id',$major)
        ->column('college_class_name');
    return $res[0];
}

/**
 * 根据id查找教师名字
 * @param $teacher_id
 * @return string
 */
function teacherName ($teacher_id){
    if ($teacher_id==null||$teacher_id==''){
        return '--';
    }else{
        $res = Db::name('Teachers')
            ->where('teacherNum',$teacher_id)
            ->column('teacher_name');
        $name=$res[0];
        return $name;
    }
}


function studentName ($students_id){
    if ($students_id==null||$students_id==''){
        return '--';
    }else{
        $res = Db::name('Students')
            ->where('studentNum',$students_id)
            ->column('stu_name');
        $name=$res[0];
        return $name;
    }
}


/**
 * 作业
 *
 * @param $task_id
 * @return mixed
 *
 */
function getTaskName ($task_id){
    $res = Db::name('Task')
        ->where('id',$task_id)
        ->column('title');
    $title=$res[0];
    return $title;
}

function Qcontent ($question_id){
    $res = Db::name('Question')
        ->where('id',$question_id)
        ->column('content');
    $content=$res[0];
    return $content;

}

