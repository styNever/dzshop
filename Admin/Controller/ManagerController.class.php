<?php

namespace Admin\Controller;
use Admin\Controller;

class ManagerController extends AdminController{
    public function add()
    {
        if(empty($_POST)){
            print_r($_POST);
        }else{
            
        }
        $this->display();
    }
    public function showlist(){
        $m_info=D('manager')->select();
        $this->assign('info',$m_info);
        $this->display();
    }
}