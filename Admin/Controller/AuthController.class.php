<?php

namespace Admin\Controller;
use Admin\Controller;
class AuthController extends AdminController{
    public function showList(){
        $auth_info=D('auth')->select();
        $this->assign('info',$auth_info);
        $this->display();
    }
    public function add(){
        $this->display();
    }
}