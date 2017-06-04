<?php

namespace Admin\Controller;
use Admin\Controller;
class AuthController extends AdminController{
    /**
    *@function name showAuth
    *@description 展示全部权限信息
    */

    public function showAuth(){
        if(session('manager')['role_id']==1){
            $total=M('auth')->count();
        }else{
            $auth_ids=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ids');//权限集合              
            $total=$this->where('auth_id in'." ($auth_ids) ")->count();
        }
        $pageSize=13;
        $pageInfo=A('Common/Util')->pageShow($total,$pageSize);     
        $auth_info=D('auth')->getAuthInfo(true,($pageInfo['page']-1)*$pageSize,$pageSize);//获取全部权限信息
        $pageInfo['info']=$auth_info;   
        $this->assign($pageInfo);
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
                session('authContro',null);
                $this->success('添加成功，即将返回权限列表',U('Admin/Auth/showAuth'));
            }else{
                $this->error('添加失败，即将返回继续添加');
            }
        }else{
            $auth_info=D('auth')->getAuthInfo();
            $this->assign('auth_info',$auth_info);
            $this->display();
        }
    }

    public function delAuth($authId=null){
        if(!$authId){
            $this->error('非法访问');
            return;
        }
        if(D('auth')->delAuth($authId)){
            session('authContro',null);            
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        } 
    }

    /**
    *@ function name updateAuth
    *@ description 更新权限信息
    */

    public function updateAuth($authId=null){
        if(!$authId){
            $this->error('非法访问');
            return;
        }
        if(!empty($_POST)){//有更新数据
            if(D('auth')->updateAuth($_POST,$authId)){
                session('authContro',null);                  
                $this->success('更新成功，即将返回权限列表',U('Admin/Auth/showAuth'));
            }else{
                $this->error('更新失败，即将返回继续更新');
            }
        }else{
            $auth_info=D('auth')->getAuthInfo();
            $currentAuth=M('auth')->find($authId);
            $this->assign(array(
                'auth_info'=>$auth_info,
                'currentAuth'=>$currentAuth,
            ));
            $this->display();
        }
    }

}