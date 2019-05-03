<?php

namespace app\admin\controller;

use think\Cache;
use app\admin\model\SiteInfo;

class System extends Base
{
    protected $pageNum = "";

    protected $pathName = 
    [
        'type6' => '用药关键字设置',
        'other' => '其他设置',

    ];

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
    public function index($type = null)
    {
        $path = $this->request->path();
        // dump($path);
        // die();
        if(!$this->auth->check($path,session('admin_id')))
            return "<div style='margin-top:100px;text-align:center;'><h1> :(&nbsp;&nbsp;&nbsp;&nbsp;you have no permission!<h1></div>";

        if($type){
            $list = $this->model->where('type',$type)->select();
            $this->assign('list', $list);
    
            $count = $this->model->where('type',$type)->count();
            $this->assign('count',$count);

            $this->assign('pathName',$this->pathName[$type]);
            $this->assign('type',$type);
            return $this->view->fetch();
        }
        
        $list = $this->model->where('type','site')->select();
        $this->assign('list', $list);

        $count = $this->model->where('type','site')->count();
        $this->assign('count',$count);

        $this->assign('type','site');
        $this->assign('pathName','基本设置');
        return $this->view->fetch();
    }

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

            if($param['value'] == $list->value and $param['description']==$list->description)
                return json('您未做修改！');
            $res = $this->model->allowField(['value','description'])->save($_POST, ['id' => $param['id']]);;    
            if($res)
            {
                $this->clearCache();
                return json(true);
            }
            else
                return json(false);

        }
        return $this->view->fetch();
    }

    public function delete($id =null)
    {
        if($this->request->isPost())
        {
            if($this->model->where('id',$id)->column('type')['0'] == 'site')
                return json('不允许删除');
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
     * //todo 1 2 3
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
