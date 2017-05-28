<?php

namespace Admin\Controller;

use Admin\Controller;

/**
 *  
 */
class GoodsController extends AdminController{

    public function addGoods(){
        if(!empty($_POST)){
            
        }else{
             $categorys=M('category')->select();
             $this->assign('categorys',$categorys);
             $this->display();
        }
    }

    public function showGoods(){
        $this->display();
    }
}
