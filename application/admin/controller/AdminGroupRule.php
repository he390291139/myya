<?php

namespace app\admin\controller;
use app\admin\model\AdminGroupRule as adminrule;
use think\Db;

class AdminGroupRule extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new adminrule();
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // $list = $this->model->paginate($this->pageNum);
        $list = Db::name('auth_group_access')->alias('a')->join('myya_admin b','a.uid = b.id')->join('myya_auth_group c','a.group_id = c.id')
        ->paginate($this->pageNum);
        $page = $list->render();
        // dump($list);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->view->fetch();
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
