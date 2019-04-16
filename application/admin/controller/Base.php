<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\auth\Auth;

class Base extends Controller
{
    protected $model;
    
    protected $auth;

    public function _initialize(){
        if(!session('admin') and !($this->request->action()=='login'))
            return $this->redirect('admin/index/login');
        $this->auth = new Auth;
    }
}
