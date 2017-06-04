<?php

namespace Admin\Controller;

use Admin\Controller;

    /**
    *  
    */
class CategoryController extends AdminController{
    /**
    *添加商品类别
    **/
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

    /**
    *删除商品类别
    **/
    public function delCategory($categoryId){
        if(!$categoryId){
            $this->error('非法访问');
            return;
        }        
        if(D('category')->delete($categoryId)){
             $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }         
    }

    /**
    *修改商品类别
    **/
    public function updateCategory($categoryId){
       if(!$categoryId){
            $this->error('非法访问');
            return;
        }       
        if(!empty($_POST)){
            $_POST['category_id']=$categoryId;
            if(D('category')->save($_POST)){
                $this->success('更新成功,即将跳转到管理员列表页','showCategory');
            }else{
                $this->error('更新失败');
            }
        }else{
            $categoryInfo=M('category')->find($categoryId);
            $this->assign('categoryInfo',$categoryInfo);
            $this->display();
        }     
    }
    /**
    *显示商品类别
    **/    
    public function showCategory(){
        $category=M('category');
        $total=$category->count();   
        $pageSize=10;
        $pageInfo=A('Common/Util')->pageShow($total,$pageSize);        
        $categorys=$category->limit(($pageInfo['page']-1)*$pageSize,$pageSize)->select();
        $pageInfo['categorys']=$categorys;
        $this->assign($pageInfo);
        $this->display();
    }
}
