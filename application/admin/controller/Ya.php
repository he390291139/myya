<?php

namespace app\admin\controller;

use think\Request;
use app\admin\model\Ya as yian;
use app\admin\model\Doctor;

class Ya extends Base
{
    protected $pageNum = "5";

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new yian();
    }

    public function index($key =null)
    {
        $list = $this->model->with(['doctor' => function ($query) {
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
        $this->assign('doc_list', $doc_list);

        if ($this->request->isPost()) 
        {
            $param = $this->request->param();
            // dump($param);
            // die();
            global $imgUrl;
            global $imgerror;
            global $videoUrl;
            global $videoerror;
            // 获取表单上传文件
            if(!$param['imgs'] == ''){
                $file = request()->file('imgs');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $imgUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $imgerror =  $file->getError();
                }
                $param['imgs'] = $imgUrl;
            }

            if(!$param['video'] == ''){
                $file = request()->file('video');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'mp4'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $videoUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $videoerror =  $file->getError();
                }
                $param['video'] = $videoUrl;
            }
            if (!is_null($imgerror))
            {
                return json("图片错误：$imgerror");
            }
            if (!is_null($videoerror))
            {
                return json("视频错误：$videoerror");
            }
            $res = $this->model->save($param);
            if($res)
                return json(true);
            else
                return json(false);

        }

        return $this->view->fetch();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id = null)
    {
        if($id == null)
            return json(false);
        $list = $this->model->get($id);
        $this->assign('user',$list);
        $doc_list = Doctor::field('id,name')->select();
        $this->assign('doc_list', $doc_list);
        
        if ($this->request->isPost()) 
        {
            $param = $this->request->param();
            // dump($param);
            // die();
            global $imgUrl;
            global $imgerror;
            global $videoUrl;
            global $videoerror;
            // 获取表单上传文件
            if(!$param['imgs'] == ''){
                $file = request()->file('imgs');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $imgUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $imgerror =  $file->getError();
                }
                $param['imgs'] = $imgUrl;
            }else{
                $param['imgs'] = $list->imgs;
            }

            if(!$param['video'] == ''){
                $file = request()->file('video');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['ext'=>'mp4'])->move(ROOT_PATH . 'public' . DS . 'uploads');

                if($info){
                    // 成功上传后 获取上传信息
                     $videoUrl =  $info->getSaveName();
                }else{
                    // 上传失败获取错误信息
                    $videoerror =  $file->getError();
                }
                $param['video'] = $videoUrl;
            }else{
                $param['video'] = $list->video;
            }
            
            if (!is_null($imgerror))
            {
                return json($imgerror);
            }
            if (!is_null($videoerror))
            {
                return json($videoerror);
            }
            $res = $this->model->save($param,['id'=>$param['id']]);
            if($res)
                return json(true);
            else
                return json(false);

        }
        return $this->fetch();
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($ids = null)
    {
        if ($this->request->isPost()) {
            $res = $this->model->destroy($ids);
            if ($res)
                return json(true);
            else
                return json(false);
        }
        return json(不允许操作);
    }
}
