<?php

namespace Admin\Model;
use Think\Model;

class ManagerModel extends Model{

    public function checkLogined($postData){
        $info=$this->getByM_name($postData['m_name']);
        if($info['m_passwd']===$postData['m_passwd']){
            return true;
        }else{
            return false;
        }
    }
}