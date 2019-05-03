<?php
namespace app\index\controller;

use think\Db;

class Index extends Base
{
    public function index()
    {

        $imgs = Db::name('doctor')->field('id,img')->select();
        $this->assign('imgs',$imgs);
        return $this->view->fetch();
    }

    public function search($key=null)
    {
        if($key){
            
            $key = \htmlspecialchars($key);
            $list = Db::name('ya')->field('')->where('title|tcm_diagnosis|wes_diagnosis|therapeutic_principle_and_method|prescription|prescription_composition|symptom','like',"%$key%")->select();
            $this->assign('list',$list);
            return $this->view->fetch();
        }
        return $this->redirect('/');
    }

    public function doctorDetail( $id = null)
    {
        if($id = null)
            return json('不存在该医生');
        $detail = Db::name('doctor')->where('id',$id)->find();
        $this->assign('detail',$detail);
        return $this->view->fetch();

    }
}
