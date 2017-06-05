<?php

namespace Admin\Controller;

use Admin\Controller;

/**
 *  
 */
class GoodsController extends AdminController{

    /**
    *添加商品
    */
    public function addGoods(){
        if(!empty($_POST)){
            $_POST['category_name']=M('category')->where('category_id='.$_POST['category_id'])->getField('category_name');
            $this->createThumb();
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
    /*
    *删除商品信息
    */

    public function delGoods($goodsId){
        if(!$goodsId){
            $this->error('非法访问');
            return;
        }
        $goods=D('goods'); 
        if($goods->delete($goodsId)){
            $goods->delImg($goodsId);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    /**
    *更新商品信息
    */

    public function updateGoods($goodsId=null){
        if(!$goodsId){
            $this->error('非法访问');
            return;
        }
        if(!empty($_POST)){
            $goods=D('goods');
            $_POST['goods_id']=$goodsId;
            if(!is_array($_FILES['goods_big_img']['size'])){//单文件上传
                if($_FILES['goods_big_img']['size']!=0){//更新商品图片
                    $goods->delImg($goodsId);
                    $this->createThumb();
                }
            }else{//多文件上传
                foreach($_FILES['goods_big_img']['size'] as $key){
                    if($key!=0){//更新商品图片
                        $goods->delImg($goodsId);
                        $upflg=true;
                        break;
                    }
                }
                if($upflg){//有更新
                    $this->createThumb();
                }
            }
            if($goods->save($_POST)){
                $this->success('更新成功','showGoods');
            }else{
                $this->error('更新失败');                   
            }              
        }else{
            $categorys=M('category')->select();
            $goodsInfo=M('goods')->find($goodsId);
            $this->assign(array(
                'goodsInfo'=>$goodsInfo,
                'categorys'=>$categorys,
            ));
            $this->display();
        }
    }

    public function showGoods(){
        $goods=M('goods');
        $total=$goods->count();   
        $pageSize=8;
        $pageInfo=A('Common/Util')->pageShow($total,$pageSize);
        $goodsInfos=$goods->limit(($pageInfo['page']-1)*$pageSize,$pageSize)->select();
        $pageInfo['goodsInfos']=$goodsInfos;
        $this->assign($pageInfo);
        $this->display();
    }

    private function createThumb(){
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
    }
}
