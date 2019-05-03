<?php
namespace app\index\controller;

use think\Validate;
use app\index\model\User as users;

class User extends Base
{
    protected $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new users();
    }

    public function register()
    {
        if($this->request->isPost())
        {
            $param = $this->request->param();

            $validate = new Validate([
                'nickname' => 'require|min:4|max:16' ,
                'username' => 'require|min:4|max:16',
                'email'    => 'require|email',
                'password' => 'require|min:6',
            ]);

            if (!$validate->check($param)) {
                return json($validate->getError());
            }
        
            $res = $this->model->get(['username' => $param['username']]);
            if ($res)
                return json("您注册的用户名已存在");
            $salt = rand(1000,9999);
            $password = getPassword($param['password'],$salt);
            $this->model->data([
                'nickname' => $param['nickname'],
                'username' => $param['username'],
                'email'    => $param['email'],
                'password' => $password,
                'salt'     => $salt
            ]);
            $res = $this->model->save();
            if($res)
                return json(true);
            else
                return json($res->getError());
        }
        return $this->view->fetch();
    }

    public function login()
    {
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
                return json($validate->getError());
            }
            $user = users::get(['username' => $param['name']]);
            if(!$user)
                return json('用户不存在！请重新输入！');
            if($user['status'] == 1)
                return json('用户已被禁用，请联系管理员！');
            if($user['password']==getPassword($password,$user['salt']))
            {
                session('user',$username);
                session('user_nickname',$user->nickname);
                session('user_id',$user['id']);
                return json(true);
            }
            return json('密码错误');
        }
        return $this->view->fetch();
    }

    public function logout(){
        session('user',null);
        session('user_id',null);
        session('user_nickname',null);
        return $this->success('退出成功',url('/'),'','2');;
    }

    public function resetPwd($id = null)
    {
        if($this->request->isPost()){
            $param = $this->request->param();
            $validate = new Validate([
                'password1' => 'require|min:6',
                'password'  => 'require|min:6',
                'password2' => 'require|min:6',
            ]);
            if (!$validate->check($param)) {
                return $this->error($validate->getError(),'','',3);
            }
            if(!$param['password'] == $param['password2'])
                return json('两次输入密码不一样');
            $user = users::get($param['id']);
            if(!$user)
                return json('用户不存在！请重新输入！');

            if($user['password']==getPassword($param['password1'],$user['salt']))
            {
                $param['password'] = getPassword($param['password'],$user['salt']);
                $res = $this->model->allowField('password')->save($param,['id'=> $param['id']]);
                if($res)
                    return json(true);
                else
                    return json($res->getError());
            }
            else{
                return json('原密码填写错误');
            }
            
        }
        $this->assign('id',$id);
        return $this->view->fetch();
    }

    public function collect()
    {
        
    }

    public function myCollect($key)
    {
        
    }

}