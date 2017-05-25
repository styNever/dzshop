<?php

namespace Admin\Controller;
use Admin\Controller;

class RoleController extends AdminController{
    public function add(){
        if(!empty($_POST)){
            if(D('role')->addRole($_POST)){
                $this->success('添加角色成功,即将跳转到角色列表','showList',3);
            }else{
                 $this->error('添加角色失败',1);
            }
        }else{
            $auth_infos=M('auth')->order('auth_path asc')->select();
            $this->assign('auth_infos',$auth_infos);
            $this->display();
        }
    }

    public function showList(){
        $role_infos=M('role')->select();
        $this->assign('role_infos',$role_infos);
        $this->display();
    }
}