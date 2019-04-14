<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function _initialize(){
        if(!session('admin') and !($this->request->action()=='login'))
            return $this->redirect('admin/index/login');
    }
}
