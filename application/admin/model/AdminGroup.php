<?php

namespace app\admin\model;

use think\Model;

class AdminGroup extends Model
{
    protected $name = 'auth_group_access';


    public function admin(){
        return $this->belongsTo('Admin','uid','id','','')->setEagerlyType('0');
    }

    public function auth(){
        return $this->belongsTo('AdminGroupRule','group_id','id','','')->setEagerlyType('0');
    }
}
