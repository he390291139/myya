<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class YaApi extends Controller
{

    public function index()
    {
        $host = $this->request->host();
        $host = 'http://'.$host.url('index/YaApi/search',['key'=>"10",'limit'=>20,'offset'=>30]);

        $this->assign('host',$host);
        
        return $this->fetch();
    }

    public function search($key=null,$limit=20,$offset=null)
    {
        if(!$key)
            $list = 'null';
        else
        {
            $key = \htmlspecialchars($key);
            if(!$offset)
            {
                $list = Db::name('ya')->field('id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')
                ->where('title|tcm_diagnosis|wes_diagnosis|therapeutic_principle_and_method|prescription|prescription_composition|symptom','like',"%$key%")
                ->limit($limit)
                ->select();
            }
            else
            {
                $list = Db::name('ya')->field('id,title,symptom,tcm_diagnosis,wes_diagnosis,therapeutic_principle_and_method,prescription,prescription_composition')
                ->where('title|tcm_diagnosis|wes_diagnosis|therapeutic_principle_and_method|prescription|prescription_composition|symptom','like',"%$key%")
                ->limit($offset,$limit)
                ->select();
            }

            if(count($list)==0)
            $list = 'null';
        }
        

        $result=[
            'code'=>'200',
            'data'=>$list,
        ];

        return json($result);
    }

}