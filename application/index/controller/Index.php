<?php
namespace app\index\controller;

use think\Db;
use app\index\model\Collect;

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
            $list = Db::name('ya')->field('id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')
                    ->where('title|tcm_diagnosis|wes_diagnosis|therapeutic_principle_and_method|prescription|prescription_composition|symptom','like',"%$key%")->select();
            $this->assign('list',$list);

            $collect = Collect::where('uid',session('user_id'))->select();

            foreach ($collect as $key => $value) {
                $collect[$key] = $value->ya_id;
            }
            
            $this->assign('collect',$collect);
            return $this->view->fetch();
        }
        return $this->redirect('/');
    }

    public function doctorDetail($id = null)
    {
        $list = Db::name('doctor')->field('id,name')->select();
        $this->assign('list',$list);

        if($id == null)
            return json('不存在该医生');
        $detail = Db::name('doctor')->where('id','=',$id)->find();
        $this->assign('detail',$detail);

        $ya = Db::name('ya')->field('id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')->where('doctor_id',$id)->select();
        $this->assign('ya',$ya);
        return $this->view->fetch();

    }
}
