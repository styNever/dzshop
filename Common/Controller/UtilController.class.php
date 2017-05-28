<?php

namespace Common\Controller;
use Think\Controller;
//工具类
class UtilController extends Controller{
   
   //对数据进行MD5加密
   public function MD5_Str($str){
        return md5($str);
    }
    /*
    *生成验证码
    */
    public function getVCode($config){
        if(!$config||!is_array($config)){//没有传参数，或者传的参数不是数组
            $config=array(
                'length'=>'5',
                'useNoise'=>true,
                'useCurve'=>true,
                'fontSize'=>26,
                'imageW'=>220,
                'imageH'=>0,
                'expire'=>600,
            );
        }
        $vCode=new \Think\Verify($config);
        return $vCode->entry();
    }    

    
}