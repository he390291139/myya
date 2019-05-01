<?php

namespace app\admin\controller;

use think\Cache;
use app\admin\model\SiteInfo;

class System extends Base
{
    protected $pageNum = "";

    public function _initialize()
    {
        parent::_initialize();
        $this->model =new SiteInfo();
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $path = $this->request->path();
        if(!$this->auth->check($path,session('admin_id')))
            return "<div style='margin-top:100px;text-align:center;'><h1> :(&nbsp;&nbsp;&nbsp;&nbsp;you have no permission!<h1></div>";

        $list = $this->model->where('type','site')->select();
        $this->assign('list', $list);

        $list = $this->model->where('type','other')->select();
        $this->assign('list1', $list);

        $count = $this->model->count();
        $this->assign('count',$count);
        return $this->view->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function add()
    {
        if($this->request->isPost())
        {
            $param = $this->request->param();
            
            $res = $this->model->get(['key'=> $param['key']]);
            
            if($res)
                return json('该关键字已存在');
            else
            {
                $res = $this->model->save($param);
                if($res)
                    return json(true);
                else
                    return json(false);
            }

        }
        return $this->view->fetch();
    }

    public function edit($id)
    {
        $list = $this->model->get($id);
        $this->assign('list', $list);
        if($this->request->isPost())
        {
            $param = $this->request->param();
            $res = $this->model->allowField(['value','description'])->save($_POST, ['id' => $param['id']]);;    
            if($res)
                return json(true);
            else
                return json(false);

        }
        return $this->view->fetch();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id =null)
    {
        if($this->request->isPost())
        {
            $res = $this->model->destroy($id);
            if($res)
                return json(true);
            else
                return json(false);
        }
        return json("不允许操作");
    }

    /**
     * 删除缓存
     *
     * @param int $type  0:删除cache文件夹内容  1:删除temp文件夹内容  2:删除log文件夹内容  3:删除runtime文件夹内容
     * @return void
     */
    public function clearCache($type = 0)
    {
        $res = Cache::clear();
        if($res)
            return json(true);
        else
            return json(false);
    }
}
