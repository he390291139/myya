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
            if (is_null($param['name']))
                return json('姓名不能为空');
            $res = $this->model->get(['name' => $param['name']]);
            if ($res)
                return json("该医生已存在，如重名请添加区别标记");

            global $imgUrl;
            global $imgerror;
            // 获取表单上传文件
            if(!$param['img'] == ''){
                $file = request()->file('img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $imgUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $imgerror =  $file->getError();
                }
                $param['img'] = $imgUrl;
            }
            if (!is_null($imgerror)){
                return json($imgerror);
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
        if ($this->request->isPost()){
            $param = $this->request->param();

            if (is_null($param['name']))
                return json('姓名不能为空');

            global $imgUrl;
            global $imgerror;
            // 获取表单上传文件
            if(!$param['img'] == ''){
                $file = request()->file('img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $imgUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $imgerror =  $file->getError();
                }
                $param['img'] = $imgUrl;
            }
            else{
                $res = $this->model->allowField('name,experience,scholastic,honorary,book,good_at_disease')->save($param,['id'=>$param['id']]);
                if($res)
                    return json(true);
                else
                    return json(false);
            }
            if (!is_null($imgerror)){
                return json($imgerror);
            }
            $res = $this->model->save($param,['id'=>$param['id']]);
            if($res)
                return json(true);
            else
                return json(false);
        }
        $user = $this->model->get($id);
        $this->assign('user',$user);
        return $this->view->fetch();
    }

    /**
     * 删除
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
     * 医生恢复
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
