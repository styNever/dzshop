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
        if(!empty($_POST)){
            //有数据提交则做验证处理
            $verify=new \Think\Verify();
            if($verify->check($_POST['vCode'])){
                $this->error('验证码错误','Index/login');
                return ;
            }
            $_POST['m_passwd']=A('Common/Util')->MD5_Str($_POST['m_passwd']);
            if(D('Manager')->checkLogined($_POST)){
                $this->success('登陆成功',U('Index/index'));
            }else{
                $this->error('账号或密码错误',U('Index/login'));
            }           
        }else{
            $this->display();
        }
    }


}