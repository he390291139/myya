<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Validate;
use app\admin\model\Admin;
use think\Session;

class Index extends Base
{

    public function index()
    {
        return $this->view->fetch();
    }

    public function welcome(){
        cache('site_title');

        return $this->view->fetch();
    }

    /**
     * login function
     *
     * @return void
     */
    public function login(){

        $path = $this->request->path();

        if($this->request->isPost()){
            $param = $this->request->param();
            $username = $param['name'];
            $password = $param['password'];

            $validate = new Validate([
                'name|登录名'     => 'require|max:25',
                'password|密码' => 'require|min:6',
                'captcha|密码'   => 'require|captcha',
            ]);
            $data = [
                'name'   => $username,
                'password'   => $password,
                'captcha'   => $param['verify'],
            ];
            if (!$validate->check($data)) {
                return $this->error($validate->getError(),'','',3);
            }
            $admin = Admin::get(['username' => $param['name']]);
            if(!$admin)
                return $this->error('用户不存在！请重新输入！');
            if(!$this->auth->check($path,$admin['id']))   
                return $this->error('you have no permission!');
            if($admin['status'] == 1)
                return $this->error('用户已被禁用，请联系超级管理员！');
            if($admin['password']==getPassword($password,$admin['salt']))
            {
                session('admin',$username);
                session('admin_id',$admin['id']);
                // Session::set(name:'user_info', $admin->getData());
                return $this->success("欢迎您！$username",url('admin/index/index'),'','3');
            }
            return $this->error('密码填写错误','','',3);
        }
        return $this->view->fetch();
    }

    public function logout(){

        session('admin',null);
        return $this->success('退出成功',url('admin/index/login'),'','3');
    }
}
