<?php

namespace Common\Controller;
use Think\Controller;
//工具类
class UtilController extends Controller{
   
   //对数据进行MD5加密
   public function MD5_Str($str){
        return md5($str);
    }
    
    
    
}