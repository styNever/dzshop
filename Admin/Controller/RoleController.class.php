<?php

namespace Admin\Controller;
use Admin\Controller;
/*
*角色类
*/
class RoleController extends AdminController{
    /**
    *添加角色
    **/ 

    private function dateProcess(){
        if($_POST['role_name']==''){
            $this->error('添加角色失败，角色名称不能为空','',1);
            return ;
        }
        if($_POST['role_auth_ids']==''){
            $this->error('添加角色失败，权限不能为空','',1);
            return ;
        }            
        $ids=implode(',',$_POST['role_auth_ids']);
        $ids=str_replace('-',',',$ids);
        $_POST['role_auth_ids']=explode(',',$ids);
        $_POST['role_auth_ids']=array_unique ($_POST['role_auth_ids']);
    }

    public function addRole(){
        if(!empty($_POST)){
            $this->dateProcess();
            if(D('role')->addRole($_POST)){
                $this->success('添加角色成功,即将跳转到角色列表','showRole',3);
            }else{
                 $this->error('添加角色失败','addRole',1);
            }
        }else{
            $auth_ids=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ids');//权限集合                          
            $auth_infos=M('auth')->where('auth_id in'." ($auth_ids) ")->order('auth_path asc')->select();
            $this->assign('auth_infos',$auth_infos);
            $this->display();
        }
    }
    
    /**
    *删除角色
    **/
    public function delRole($roleId){
        if(!$roleId){
            $this->error('非法访问');
            return;
        } 
        if($roleId==1){
            $this->error('删除失败,该角色不允许被删除！！！');  
            return;
        }       
        if(D('role')->delRole($roleId)){
             $this->success('删除成功');
        }else{
            $this->error('删除失败,请先删除与该角色有关的管理员');
        }            
    }

    /**
    *更新角色
    **/

    public function updateRole($roleId){
       if(!$roleId){
            $this->error('非法访问');
            return;
        }       
        if(!empty($_POST)){
            $this->dateProcess();
            $_POST['role_id']=$roleId;
            if(D('role')->updateRole($_POST)){
                $this->success('更新成功,即将跳转到管理员列表页','showRole');
            }else{
                $this->error('更新失败');
            }
        }else{
            $roleInfo=M('role')->find($roleId);
            $auth_infos=M('auth')->select(); 
            $roleInfo['role_auth_ids']=explode(',',$roleInfo['role_auth_ids']);       
            $this->assign(array(
                'roleInfo'=>$roleInfo,
                'auth_infos'=>$auth_infos,
            ));
            $this->display();
        }            
    }   

    /**
    *显示角色列表
    **/       
    public function showRole(){
        $role_infos=M('role')->select();
        $this->assign('role_infos',$role_infos);
        $this->display();
    }
}