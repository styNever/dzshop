<?php

namespace Admin\Model;
use Think\Model;

class ManagerModel extends Model{

    public function checkLogined($postData){
        $this->postCheck();
        $info=$this->getByM_name($postData['m_name']);
        if($info['m_passwd']===$postData['m_passwd']){
            session('manager',$info);
            return true;
        }else{
            return false;
        }
    }

    public function postCheck(){
        return preg_match('/\W/',$_POST['m_name'])&&preg_match('/\W/',$_POST['m_passwd']);
    }
}