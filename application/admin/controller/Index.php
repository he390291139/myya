<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Validate;
use app\admin\model\Admin;

class Index extends Base
{
    public function index()
    {
        return $this->view->fetch();
    }

    public function welcome(){

        return $this->view->fetch();
    }

    /**
     * login function
     *
     * @return void
     */
    public function login(){
        if($this->request->isPost()){
            $param = $this->request->param();
            $username = $param['name'];
            $password = $param['password'];

            $validate = new Validate([
                'name'     => 'require|max:25',
                'password' => 'require|min:6',
                'captcha'   => 'require|captcha',
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
            if($admin['password']==getPassword($password,$admin['salt']))
            {
                session('admin','admin');
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
