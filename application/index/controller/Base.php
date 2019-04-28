<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    protected $model;
    
    protected $auth;

    public function _initialize(){

    }
}
