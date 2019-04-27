<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Doctor extends Model
{
    use SoftDelete;
    protected $name = 'doctor';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';
    protected $deleteTime = 'deleteTime';
}
