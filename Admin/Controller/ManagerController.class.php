<?php

namespace Admin\Controller;
use Admin\Controller;

class ManagerController extends AdminController{
    public function add()
    {
        if(!empty($_POST)){
            $_POST['m_lastip']=get_client_ip();
            $_POST['m_passwd']=A('Common/Util')->MD5_Str($_POST['m_passwd']);
            if(D('manager')->add($_POST)){
                $this->success('添加成功,即将跳转到管理员列表页',U('Admin/Manager/showlist'));
            }else{
                $this->error('添加失败，将返回继续添加',U('Admin/Manager/add'));
            }
        }else{
            $role_infos=M('role')->select();
            $this->assign('role_infos',$role_infos);
            $this->display();
        }

    }
    public function showlist(){
        $m_info=D('manager')->select();
        $this->assign('info',$m_info);
        $this->display();
    }
}