<?php

namespace app\admin\controller;

use think\Validate;
use app\admin\model\Admin as AdminModel;

class Admin extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new AdminModel();
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = $this->model->field('id,username,email,nickname,status,createTime')->paginate($this->pageNum);
        $page = $list->render();
        $count = $this->model->count('id');
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->view->fetch();
    }

    public function add(){
        
        if ($this->request->isPost()){
            
            $param = $this->request->param();

            $validate = new Validate([
                'nickname' => 'require|min:4|max:16' ,
                'username' => 'require|min:4|max:16',
                'email'    => 'require|email',
                'password' => 'require|min:6',
                'status'   => 'require',
            ]);

            if (!$validate->check($param)) {
                return json($validate->getError());
            }
        
            $res = $this->model->get(['username' => $param['username']]);
            if ($res)
                return json("该用户已存在");
            $salt = rand(1000,9999);
            $password = getPassword($param['password'],$salt);
            $this->model->data([
                'nickname' => $param['nickname'],
                'username' => $param['username'],
                'email'    => $param['email'],
                'password' => $password,
                'status'   => $param['status'],
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

    public function edit($id)
    {
        $user = $this->model->get($id);
        $this->assign('user',$user);
        return $this->view->fetch();

        
        if($this->request->isPost()){
            $param = $this->request->param();
            
            $validate = new Validate([
                'nickname' => 'require|min:4|max:16' ,
                'email'    => 'require|email',
                'status'   => 'require',
            ]);
            if (!$validate->check($param)) {
                return json($validate->getError());
            }
            $res = $this->model->allowField(['nickname','email','status'])->save($param,['id' => $param['id']]);
            if($res)
                return json(true);
            else{
                return json(false);
            }
        }
        
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($ids =null)
    {
        if($this->request->isPost()){
            $self_id = session('admin');
            if($self_id == $ids)
                return json("cant't delete yourself!");
            $res = $this->model->destroy($ids);
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json("不允许操作");
    }

    public function status($id = null,$status = null){
        if ($this->request->isPost()){
            
            if ($id == null or $status ==null)
                return json('参数错误');
            
            $status = $status == 1 ? 0 : 1;
            $res = $this->model->save(['status'=>$status],['id'=>$id]);
            if ($res)
                return json(true);
            else
                return json(false);
        }
        return $this->error('error');
    }
}
