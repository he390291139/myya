<?php

namespace app\admin\model;

use think\Model;

class Ya extends Model
{
    protected $name = 'ya';

    public function doctor(){
        return $this->belongsTo('Doctor','doctor_id','id','','')->setEagerlyType('0');
    }
}
