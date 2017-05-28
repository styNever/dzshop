<?php

namespace Admin\Controller;
use Admin\Controller;
class AuthController extends AdminController{
    /**
    *@function name showAuth
    *@description 展示全部权限信息
    */
    public function showAuth(){
        $auth_info=D('auth')->getAuthInfo(true);
        $this->assign('info',$auth_info);
        $this->display();
    }

    /**
    *@function name add
    *@description 添加权限信息
    */  
    public function addAuth(){
        if(!empty($_POST)){
            // 有数据提交
            if(D('auth')->addAuth($_POST)){
                $this->success('添加成功，即将返回权限列表',U('Admin/Auth/showAuth'));
            }else{
                $this->success('添加失败，即将返回继续添加',U('Admin/Auth/addAuth'));
            }
        }else{
            $auth_info=D('auth')->getAuthInfo();
            $this->assign('auth_info',$auth_info);
            $this->display();
        }
    }
}