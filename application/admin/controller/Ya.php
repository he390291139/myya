<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Ya as yian;
use app\admin\model\Doctor;

class Ya extends Base
{
    protected $pageNum = "20";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new yian();
    }

    public function index()
    {
        $list = $this->model->with(['doctor'=>function($query){
            $query->withField('name');
            $query->field('name');
        }])->paginate($this->pageNum);
        $page = $list->render();
        $count = $this->model->count('id');
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        return $this->view->fetch();
    }

    public function add()
    {
        $doc_list = Doctor::field('id,name')->select();
        $this->assign('doc_list',$doc_list);
        dump($doc_list);
        die();
        return $this->view->fetch();
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
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($ids =null)
    {
        if($this->request->isPost()){
            $res = $this->model->destroy($ids);
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json(不允许操作);
    }
}
