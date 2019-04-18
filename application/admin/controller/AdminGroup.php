<?php

namespace app\admin\controller;

use app\admin\model\AdminGroup as adming;
use app\admin\model\AdminGroupRule;
use app\admin\model\Admin;

class AdminGroup extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new adming();
    }

    public function index()
    {
        $list = $this->model
                    ->with(['admin'=>function($query){
                            $query->withField('nickname,username');
                            $query->field('nickname,username');
                        },'auth'=>function($query){
                            $query->withField('title');
                            $query->field('title');}])
                    ->paginate($this->pageNum);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);

        $groupList = AdminGroupRule::all(function($query){
            $query->field('id,title');
        });

        $this->assign('groupList',$groupList);

        $count = $this->model->count();
        $this->assign('count',$count);
        return $this->view->fetch();
    }

    public function alterGroup(){

    }

    public function add(){
        $user = Admin::all(function($query){
            $query->field('id,username');
        });
        $groupList = AdminGroupRule::all(function($query){
            $query->field('id,title');
        });

        if ($this->request->isPost()){
            
            $param = $this->request->param();
            $res = $this->model->get(['uid' => $param['uid'],'group_id'=>$param['group_id']]);
            if ($res)
                return json("该权限已存在");
            $this->model->data($param);
            $res = $this->model->save();
            if($res)
                return json(true);
            else
                return json($res->getError());
        }

        $this->assign('user',$user);
        $this->assign('groupList',$groupList);
        return $this->view->fetch();

    }

    public function delete($ids,$groupid){
        if($this->request->isPost()){
            $self_id = session('admin');
            if($self_id !== 'admin')
                return json("you have no permission!");
            if($groupid == 1 and $ids == 1)
                return json("you can't remove yourself from superAdminGroup!");
            $res = $this->model->where('uid','=',$ids)->where('group_id','=',$groupid)->delete();
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json("不允许操作");
    }
}
