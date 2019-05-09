<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Ya;
use think\Db;
use app\admin\model\Doctor;

class Analyze extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $res = Db::name('doctor')->field('id,name')->select();

        
        foreach ($res as $key => $value) 
        {
            $res[$key]['name'] = $value['name'];
            $res[$key]['value'] = Db::name('ya')->where('doctor_id',$value['id'])->count();
            unset($res[$key]['id']);
        }

        $res2 = array();
        foreach ($res as $key => $value) 
        {
            if($value['value']<=0)
                $res2[$value['name']] = false;
            else
                $res2[$value['name']] = true;
        }

        $this->assign('res',json_encode($res));
        $this->assign('res2',json_encode($res2));
        return $this->fetch();
    }

    public function zhanglei($doc_id = 1,$key2 = '胃痛')
    {
        if($name = $this->request->param('name'))
        {
            $res = Doctor::where('name','like',"$name")->find()->id;
            if($res)
                $doc_id = $res;
        }

        if($key2 = htmlspecialchars($this->request->param('key2')) == '')
            $key2 = '胃痛';
        $name = Doctor::get($doc_id)->name;
        $this->assign('name',$name);
        $this->assign('key2',$key2);

        if(cache('yongyao'))
        {
            $yongyao = cache('yongyao');
        }else
        {
            $yongyao = Db::name('site_info')
            ->field('value')
            ->where('type','type6')
            ->select();
            cache('yongyao',$yongyao);
        }

        $listx = array();
        $listy = array();
        foreach ($yongyao as $key => $value) 
        {
            $key1 = $value['value'];
            $list = Db::name('ya')
            ->where('doctor_id',$doc_id)
            ->where('title|tcm_diagnosis','like',"%$key2%")
            ->field('prescription_composition')
            ->where('prescription_composition','like',"%$key1%")
            ->select();

            $count = count($list);
            if(!$count == 0)
            {
                array_push($listx,$key1);
                array_push($listy,$count);
            }
        }

        $num = count(Db::name('ya')
        ->where('doctor_id',$doc_id)
        ->where('title','like',"%$key2%")->select());
        $this->assign('num',json_encode($num));
        $this->assign('listx',json_encode($listx));
        $this->assign('listy',json_encode($listy));




        $res = array_combine($listx,$listy);
        $i = 0;
        foreach ($res as $key => $value) 
        {
            $res[$i]['name'] = $key;
            $res[$i]['value'] = $value;
            $i++;
            unset($res[$key]);
        }
        
        $res2 = array();
        foreach ($res as $key => $value) 
        {
                $res2[$value['name']] = true;
        }

        $this->assign('res',json_encode($res));
        $this->assign('res2',json_encode($res2));



        return $this->fetch();
    }
}
