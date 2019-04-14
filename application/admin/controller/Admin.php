<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

class Admin extends Controller
{
    protected $pageNum = "10";
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = Db::name('admin')->field('id,username,email,nickname,status,createTime')->paginate($this->pageNum);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->view->fetch();
    }

    public function add(){
        $salt = rand(1000,9999);
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
}
