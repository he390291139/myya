<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use app\admin\model\SiteInfo;

if(!function_exists('getPassword')){
    function getPassword($password,$salt){
        return md5(md5($password).$salt);       
    }
}


if(!function_exists('getSiteInfo')){
    function getSiteInfo($key){
        if(cache($key))
            return cache($key);
        else{
            $res = SiteInfo::get(['key' => $key]);
            if($res){
                cache($key,$res->value);
                return cache($key);
            }
            return "名医医案";
        }
    }
}