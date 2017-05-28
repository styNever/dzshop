<?php

namespace Admin\Controller;

use Admin\Controller;

/**
 *  
 */
class CategoryController extends AdminController{

    public function addCategory(){
        if(!empty($_POST)){
            if(D('category')->add($_POST)){
                $this->success('添加成功,即将跳转到商品分类列表页','showCategory');
            }else{
                $this->error('添加失败，请重新添加');
            }
        }else{
            $this->display();
        }
    }

    public function showCategory(){
        $categorys=M('category')->select();
        $this->assign('categorys',$categorys);
        $this->display();
    }
}
