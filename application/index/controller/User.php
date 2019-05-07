<?php
namespace app\index\controller;

use think\Validate;
use app\index\model\User as users;
use think\Db;
use app\index\model\Collect;

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
        if ($this->request->isPost()) {
            $param = $this->request->param();

            $validate = new Validate([
                'nickname' => 'require|min:4|max:16',
                'username' => 'require|min:4|max:16',
                'email'    => 'require|email',
                'password' => 'require|min:6|alphaNum',
            ]);

            if (!$validate->check($param)) {
                return json($validate->getError());
            }

            $res = $this->model->get(['username' => $param['username']]);
            if ($res)
                return json("您注册的用户名已存在");
            $salt = rand(1000, 9999);
            $password = getPassword($param['password'], $salt);
            $this->model->data([
                'nickname' => $param['nickname'],
                'username' => $param['username'],
                'email'    => $param['email'],
                'password' => $password,
                'salt'     => $salt
            ]);
            $res = $this->model->save();
            if ($res)
                return json(true);
            else
                return json($res->getError());
        }
        return $this->view->fetch();
    }

    public function login()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $username = $param['name'];
            $password = $param['password'];

            $validate = new Validate([
                'name'     => 'require|max:25',
                'password' => 'require|min:6|alphaNum',
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
            if (!$user)
                return json('用户不存在！请重新输入！');
            if ($user['status'] == 1)
                return json('用户已被禁用，请联系管理员！');
            if ($user['password'] == getPassword($password, $user['salt'])) {
                session('user', $username);
                session('user_nickname', $user->nickname);
                session('user_id', $user['id']);
                return json(true);
            }
            return json('密码错误');
        }
        return $this->view->fetch();
    }

    public function logout()
    {
        session('user', null);
        session('user_id', null);
        session('user_nickname', null);
        return $this->success('退出成功', url('/'), '', '2');;
    }

    public function resetPwd($id = null)
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            $validate = new Validate([
                'password1' => 'require|min:6|alphaNum',
                'password'  => 'require|min:6|alphaNum',
                'password2' => 'require|min:6|alphaNum',
            ]);
            if (!$validate->check($param)) {
                return json($validate->getError());
            }
            if (!$param['password'] == $param['password2'])
                return json('两次输入密码不一样');
            $user = users::get($param['id']);
            if (!$user)
                return json('用户不存在！请重新输入！');

            if ($user['password'] == getPassword($param['password1'], $user['salt'])) {
                $param['password'] = getPassword($param['password'], $user['salt']);
                $res = $this->model->allowField('password')->save($param, ['id' => $param['id']]);
                if ($res)
                    return json(true);
                else
                    return json($res->getError());
            } else {
                return json('原密码填写错误');
            }
        }
        $this->assign('id', $id);
        return $this->view->fetch();
    }

    public function collect($ya_id = null)
    {
        $uid = session('user_id');
        if ($this->request->isPost()) {
            if($uid == null)
                return \json('您需要登录后才可以收藏！');
            if (!$ya_id == null and !$uid == null) {
                $newCollect = new Collect([
                    'uid'  =>  $uid,
                    'ya_id' =>  $ya_id
                ]);
                $res = $newCollect->save();

                if ($res)
                    return json(true);
                else
                    return json($res->getError());
            }
            return json('参数错误');
        }
        return json(false);
    }

    public function uncollect($ya_id = null)
    {
        if ($this->request->isPost()) {

            $uid = session('user_id');
            if($uid == null)
                return \json('您需要登录后才可以收藏！');
                
            if (!$ya_id == null and !$uid == null) {

                $res = Collect::destroy(['ya_id' => $ya_id, 'uid' => $uid]);

                if ($res)
                    return json(true);
                else
                    return json($res->getError());
            }
            return json('参数错误');
        }
        return json(false);
    }

    public function myCollect($key = null)
    {
        if ($key) {
            $list = Db::name('collect')
                ->alias('c')
                ->join('ya', 'c.ya_id = ya.id', 'LEFT')
                ->where('uid', session('user_id'))
                ->field('ya.id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')
                ->where('title|tcm_diagnosis|wes_diagnosis|therapeutic_principle_and_method|prescription|prescription_composition|symptom','like',"%$key%")
                ->select();
            $this->assign('list', $list);

            $collect = Collect::where('uid', session('user_id'))->select();

            foreach ($collect as $key => $value) {
                $collect[$key] = $value->ya_id;
            }

            $this->assign('collect', $collect);
            return $this->view->fetch();
        }
        $list = Db::name('collect')
            ->alias('c')
            ->join('ya', 'c.ya_id = ya.id', 'LEFT')
            ->where('uid', session('user_id'))
            ->field('ya.id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')
            ->select();
        $this->assign('list', $list);

        $collect = Collect::where('uid', session('user_id'))->select();

        foreach ($collect as $key => $value) {
            $collect[$key] = $value->ya_id;
        }

        $this->assign('collect', $collect);
        return $this->view->fetch();
    }
}
