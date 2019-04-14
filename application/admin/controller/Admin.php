<?php

namespace app\admin\controller;

use think\Request;
use think\Db;
use app\admin\model\Admin as AdminModel;

class Admin extends Base
{
    protected $pageNum = "10";

    protected $model;

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
        //todo 可能存在分页错误，后面再改
        $list = Db::name('admin')->field('id,username,email,nickname,status,createTime')->paginate($this->pageNum);
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

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
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