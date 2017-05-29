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
        if(session('?manager')){
            $this->getAuth();
        }
    }
    function index(){
        
    }
    private function getAuth(){
        if(!session('?authContro')){//是否还要读库
            $auth_ids=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ids');
            $auth=M('auth')->where('auth_id in'." ($auth_ids) ")->order('auth_id asc,auth_path asc')->select();
            foreach($auth as $key){//分离主菜单和次级菜单
                if($key['auth_level']==1){ //次级菜单                
                    $items[$key['auth_pid']][]=$key;                
                }else if($key['auth_level']==0){
                    $menus[]=$key;//主菜单
                }
            }             
            $auths=array(
                'menus'=>$menus,
                'items'=>$items,
            );
            session('authContro',$auths);
        }else{
            $auths=session('authContro');
        }
        $this->assign($auths);
    }
}