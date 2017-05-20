<?php
namespace Admin\Controller;
use Admin\Controller;
class IndexController extends AdminController {
    public function index(){

        $this->display();
    }
    public function login(){

        if(!empty($_POST)){
            //有数据提交则做验证处理
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