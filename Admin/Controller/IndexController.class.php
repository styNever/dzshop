<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if(!session('?manager')){//当前没有登录跳转到登录页
            $this->redirect('admin/index/login');
            return ;
        }
        new AdminController();
        $this->display();
    }
    public function login(){
        if(session('manager')){
            $this->redirect('admin/index/index');
        }
        if(!empty($_POST)){
            //有数据提交则做验证处理
            $verify=new \Think\Verify();
            if($verify->check($_POST['vCode'])){                
                $this->ajaxReturn(array(
                   'message'=>'验证码错误',
                   'errorCode'=>'2',
                ));
                return ;
            }
            
            if(D('Manager')->postCheck()){
                $this->ajaxReturn(array(
                    'errorCode'=>'3',
                    'message'=>'账号或密码不合法，只允许数字字母下划线',
                ));               
                return;
            }
            $_POST['m_passwd']=A('Common/Util')->MD5_Str($_POST['m_passwd']);
            if(D('Manager')->checkLogined($_POST)){
                $this->ajaxReturn(array(
                    'url'=>'index.html',
                    'message'=>'登陆成功',
                ));
            }else{
                $this->ajaxReturn(array(
                    'errorCode'=>'1',
                    'message'=>'账号或密码错误',
                ));
                return ;
            }           
        }else{
            $this->display();
        }
    }

}