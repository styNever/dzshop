<?php

namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller{
    function __construct(){
        parent::__construct();
        if(!session('?manager')&&ACTION_NAME!=login){//当前没有登录跳转到登录页
            $this->redirect('admin/index/login');
            return ;
        }
        $this->getAuth();
    }
    function index(){
        
    }
    private function getAuth(){
        $auth=M('auth')->where('auth_level<2')->order('auth_id asc,auth_path asc')->select();
        foreach($auth as $key){
            if($key['auth_level']!=0){                 
                $items[$key['auth_pid']][]=$key;                
              }else{
                  $menus[]=$key;
              }
        }              
        $this->assign('menus',$menus);
        $this->assign('items',$items);
    }
}