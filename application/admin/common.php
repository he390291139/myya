<?php

if(!function_exists('getPassword')){
    function getPassword($password,$salt){
        return md5(md5($password).$salt);       
    }
}
