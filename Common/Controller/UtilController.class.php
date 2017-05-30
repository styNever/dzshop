<?php

namespace Common\Controller;
use Think\Controller;
//工具类
class UtilController extends Controller{
   
   //对数据进行MD5加密
   public function MD5_Str($str){
        return sha1(md5(md5($str)+'hello'));
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

    /**
    *文件上传*
    */
    public function upload($config){
        if(!$config||!is_array($config)){
            $config=array(
                'rootPath'=>'./public/uploads/',//上传根目录
                'maxSize'=>1024*1024*10,
                'savePath'=>'',//相对根目录的保存目录
                'autoSub'=>true,
                'subName'=>array('date','Ymd'),//自动生成子目录
                'savaName'=>array('uniqid',''),//唯一文件名
                'exts'=>array('jpg','jpeg','png','gif')
            );
        }
        $upload=new \Think\Upload($config);
        $uploadInfo=$upload->upload();
        if(!$uploadInfo){
            return $upload->getError();
        }
        return $uploadInfo;
    }

    /*
    *生成缩略图*
    */
    public function createThumb($img,$width,$heigth){    
        if(empty($img)){
            return;
        }    
        $img['savepath']='./public/uploads/'.$img['savepath'];
        $thumb=new \Think\Image();
        $thumb->open($img['savepath'].$img['savename']);
        if(!$width){
            $width=$thumb->width()*0.25;
        }
        if(!$heigth){
            $heigth=$thumb->height()*0.25;
        }
        $thumb->thumb($width,$heigth)->save($img['savepath'].'thumb'.$img['savename']);
    }    
}