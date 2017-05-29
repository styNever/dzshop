<?php

namespace Admin\Controller;

use Admin\Controller;

/**
 *  
 */
class GoodsController extends AdminController{

    public function addGoods(){
        if(!empty($_POST)){
            $util=new \Common\Controller\UtilController();
            $uploadInfo=$util->upload();
            $_POST['goods_big_img']=null;
            if(is_array($uploadInfo)){//上传成功
               foreach($uploadInfo as $img){
                    $_POST['goods_big_img'].='/public/uploads/'.$img['savepath'].$img['savename'];
                    $_POST['goods_img_hash']=$img['sha1'];
                    $util->createThumb($img);      //生成缩略图              
                    $_POST['goods_small_img'].='/public/uploads/'.$img['savepath'].'thumb'.$img['savename'];                    
               }
            }else{//上传失败
                $this->error($uploadInfo);
                return;
            }
            if(D('goods')->add($_POST)){
                $this->success('添加成功','showGoods');
            }else{
                $this->error('添加失败，请重新添加');                   
            }
        }else{
             $categorys=M('category')->select();
             $this->assign('categorys',$categorys);
             $this->display();
        }
    }

    public function showGoods(){
        $goodsInfos=M('goods')->select();
        $this->assign('goodsInfos',$goodsInfos);
        $this->display();
    }
}
