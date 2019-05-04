<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Ya;
use think\Db;

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

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
