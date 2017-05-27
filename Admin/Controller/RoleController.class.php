<?php

namespace Admin\Controller;
use Admin\Controller;

class RoleController extends AdminController{
    public function add(){
        if(!empty($_POST)){
            if($_POST['role_name']==''){
                $this->error('添加角色失败，角色名称不能为空','add',1);
                return ;
            }
            if($_POST['role_auth_ids']==''){
                $this->error('添加角色失败，权限不能为空','add',1);
                return ;
            }            
            $ids=implode(',',$_POST['role_auth_ids']);
            $ids=str_replace('-',',',$ids);
            $_POST['role_auth_ids']=explode(',',$ids);
            $_POST['role_auth_ids']=array_unique ($_POST['role_auth_ids']);
            if(D('role')->addRole($_POST)){
                $this->success('添加角色成功,即将跳转到角色列表','showList',3);
            }else{
                 $this->error('添加角色失败','add',1);
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