<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Doctor as docto;
use think\Validate;

class Doctor extends Base
{
    protected $pageNum = "10";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new docto();
    }

    public function index()
    {
        $list = $this->model->paginate($this->pageNum);
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
            $res = $this->model->get(['name' => $param['name']]);
            if ($res)
                return json("该医生已存在，如重名请添加区别标记");
            // 获取表单上传文件
            if(!$param['img'] == ''){
                $file = request()->file('img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
                global $imgUrl;
                global $imgerror;
                if($info){
                    // 成功上传后 获取上传信息
                     $imgUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $imgerror =  $file->getError();
                }
                $param['img'] = $imgUrl;
            }
            $this->model->data($param);
            $res = $this->model->save();
            if($res)
                return json(true);
            else
                return json(false);
        }
        return $this->view->fetch();
    }

    public function edit($id)
    {
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
        $user = $this->model->get($id);
        $this->assign('user',$user);
        return $this->view->fetch();
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
}
