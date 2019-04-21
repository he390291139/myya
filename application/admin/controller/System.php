<?php

namespace app\admin\controller;

use think\Cache;
use app\admin\model\siteInfo;

class System extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model =new siteInfo();
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
        $this->assign('list', $list);
        $this->assign('page', $page);
        $count = $this->model->count();
        $this->assign('count',$count);
        return $this->view->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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

    /**
     * 删除缓存
     *
     * @param int $type  0:删除cache文件夹内容  1:删除temp文件夹内容  2:删除log文件夹内容  3:删除runtime文件夹内容
     * @return void
     */
    public function clearCache($type = 0){
        $res = Cache::clear();
        if($res)
            return json(true);
        else
            return json(false);
    }
}
