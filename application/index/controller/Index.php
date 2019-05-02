<?php
namespace app\index\controller;

use think\Db;

class Index extends Base
{
    public function index()
    {
        $tabs1 = Db::name('doctor')->field('name')->select();
        $this->assign('tabs1',$tabs1);

        $tabs2 = Db::name('ya')->field('tcm_diagnosis')->group('tcm_diagnosis')->select();
        $this->assign('tabs2',$tabs2);

        $tabs3 = Db::name('ya')->field('wes_diagnosis')->group('wes_diagnosis')->select();
        $this->assign('tabs3',$tabs3);
        // dump($tabs3);
        // die();

        $tabs4 = Db::name('ya')->field('therapeutic_principle_and_method')->group('therapeutic_principle_and_method')->select();
        $this->assign('tabs4',$tabs4);

        $tabs5 = Db::name('ya')->field('prescription')->group('prescription')->select();
        $this->assign('tabs5',$tabs5);

        $tabs6 = Db::name('site_info')->where('type','type6')->select();
        $this->assign('tabs6',$tabs6);

        return $this->view->fetch();
    }

    public function search($key=null){
        if($key){
            $tabs1 = Db::name('doctor')->field('name')->select();
            $this->assign('tabs1',$tabs1);
    
            $tabs2 = Db::name('ya')->field('tcm_diagnosis')->group('tcm_diagnosis')->select();
            $this->assign('tabs2',$tabs2);
    
            $tabs3 = Db::name('ya')->field('wes_diagnosis')->group('wes_diagnosis')->select();
            $this->assign('tabs3',$tabs3);
            // dump($tabs3);
            // die();
    
            $tabs4 = Db::name('ya')->field('therapeutic_principle_and_method')->group('therapeutic_principle_and_method')->select();
            $this->assign('tabs4',$tabs4);
    
            $tabs5 = Db::name('ya')->field('prescription')->group('prescription')->select();
            $this->assign('tabs5',$tabs5);
    
            $tabs6 = Db::name('site_info')->where('type','type6')->select();
            $this->assign('tabs6',$tabs6);


            $key = \htmlspecialchars($key);
            $list = Db::name('ya')->field('')->where('title|patient_name','like',"%$key%")->select();
            $this->assign('list',$list);
            return $this->view->fetch();
        }
        return $this->redirect('/');
    }
}
