<?php

namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller{
    /**
    *检查权限，检查是否登陆*
    */
    function __construct(){
        parent::__construct();
        if(!session('?manager')){//当前没有登录跳转到登录页
            $this->redirect('admin/index/login');
            return ;
        }
        if(session('?manager')){
            if(!$this->checkContro()&&session('manager')['role_id']!=1){
                $this->error('没有权限访问');
                return;
            }
            $this->getAuth();//获取当前用户权限信息
        }
    }
    function index(){
        //控制器空处理
    }

    /*
    *得到当前用户的各级权限*
    */

    private function getAuth(){
        if(!session('?authContro')){//是否还要处理，子菜单和父级菜单分离
            if(session('manager')['role_id']!=1){
                $auth_ids=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ids');//权限集合
                $auth=M('auth')->where('auth_id in'." ($auth_ids) ")->order('auth_path asc')->select();
            }else{
                $auth=M('auth')->order('auth_path asc')->select();//得到所有权限                
            }
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
        }
        $this->assign(session('authContro'));
    }

    /*
    *检测当前用户是否拥有权限，并且检测是否已经读库*
    * return ture 拥有权限，false 没有权限*
    */
    private function checkContro(){
        if(!session('controAction')){//没有读取用户控制器权限信息
            $role_auth_ca=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ca');
            $role_auth_ca=strtolower($role_auth_ca);
            $role_actions=explode(',',$role_auth_ca);
            $role_actions[]='index-index';
            session('controAction',$role_actions);
        }
        return in_array(strtolower(CONTROLLER_NAME.'-'.ACTION_NAME),session('controAction'));
    }
}