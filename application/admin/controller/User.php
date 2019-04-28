<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\User as Userinfo;

class User extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new Userinfo();
    }
       /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = $this->model->paginate($this->pageNum);
        $page = $list->render();
        $count = $this->model->count('id');
        $this->assign('user', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->view->fetch();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function resetPwd($id)
    {
        return $this->view->fetch();
    }

    public function delete($ids =null)
    {
        if($this->request->isPost()){
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

    /**
     * 回收站
     *
     * @return void
     */
    public function recycle(){

        $list = $this->model->onlyTrashed()->paginate($this->pageNum);
        $page = $list->render();
        $count = $this->model->onlyTrashed()->count('id');
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->view->fetch();
    }
    /**
     * 恢复
     *
     * @param [type] $ids
     * @return void
     */
    public function restore($ids = null){
        if($this->request->isPost()){
            $res = $this->model->restore(['id'=>$ids]);
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json('不允许操作');
    }

    public function destroy($ids = null){
        if($this->request->isPost()){
            $res = $this->model->destroy(['id'=>$ids],true);
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json('不允许操作');
    }
}