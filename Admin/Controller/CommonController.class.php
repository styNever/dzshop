<?php

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller{

    public function index(){
        
    }

    // 返回验证码给前端显示
    public function getVCode(){
        $util=new \Common\Controller\UtilController();
        return $util->getVCode();
    }
    //退出系统
    public function loginOut(){
        session(null);
        $this->redirect('index/login');
    }
}