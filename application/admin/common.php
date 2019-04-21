<?php
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