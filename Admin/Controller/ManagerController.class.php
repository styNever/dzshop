<?php

namespace Admin\Controller;
use Admin\Controller;

class ManagerController extends AdminController{
    /**
    *添加管理员
    **/
    public function addManager()
    {
        if(!empty($_POST)){
            $_POST['m_lastip']=get_client_ip();
            $_POST['m_passwd']=A('Common/Util')->MD5_Str($_POST['m_passwd']);
            if(D('manager')->add($_POST)){
                $this->success('添加成功,即将跳转到管理员列表页',U('Admin/Manager/showManager'));
            }else{
                $this->error('添加失败，将返回继续添加',U('Admin/Manager/addManager'));
            }
        }else{
            $role_infos=M('role')->select();
            $this->assign('role_infos',$role_infos);
            $this->display();
        }

    }

    /**
    *删除管理员
    **/
    public function delManager($managerId){
       if(!$managerId){
            $this->error('非法访问');
            return;
        }
        if(D('manager')->delete($managerId)){
             $this->success('删除成功');
        }else{
            $this->error('删除失败');
        } 
    }    
    /**
    *修改管理员信息
    **/
    public function updateManager($managerId){
       if(!$managerId){
            $this->error('非法访问');
            return;
        }
        if(!empty($_POST)){
            if($_POST['m_passwd']===''){
                unset($_POST['m_passwd']);
            }else{
                $_POST['m_passwd']=A('Common/Util')->MD5_Str($_POST['m_passwd']);
                $_POST['m_id']=$managerId;
                if(D('manager')->save($_POST)){
                    $this->success('更新成功,即将跳转到管理员列表页','showManager');
                }else{
                    $this->error('更新失败');
                }
            }
        }else{
            $managerInfos=M('manager')->find($managerId);
            $role_infos=M('role')->select();
            $this->assign(array(
                'managerInfos'=>$managerInfos,
                'role_infos'=>$role_infos,
            ));
            $this->display();
        }
    }  
    /**
    *显示管理员列表
    **/
    public function showManager(){
        $m_info=D('manager')->select();
        $this->assign('info',$m_info);
        $this->display();
    }
}