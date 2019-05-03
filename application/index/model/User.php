<?php
namespace app\index\model;

use think\Model;

class User extends Model
{
    protected $name = 'user';

    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';
}