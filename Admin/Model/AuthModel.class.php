<?php

namespace Admin\Model;
use Think\Model;

class AuthModel extends Model{

    /**
    *@function name addAuth 
    *@type boolean 是否添加成功
    *@description 添加权限
    *@ param $pData 要添加的数据
    */
    public function addAuth($pData){
        // 添加权限
        $auth_id=$this->add($pData);        
        $insertData=$this->insertBefore($pData,$auth_id);
        return $this->save($insertData);
    }

    public function updateAuth($pData,$auth_id){
        $insertData=$this->insertBefore($pData,$auth_id);
        return $this->save($insertData);
    }


    public function delAuth($auth_id){
        $childAuth=$this->where('auth_pid='.$auth_id)->select();
        if($childAuth){
            return false;
        }else{
            return $this->delete($auth_id);
        }
    }

/*
* @function name getAuthInfo 
* @description 获取权限信息
* @param boolean 
* @$flag true 获取全部信息
* @flag false 获取权限等级小于2的信息
*/
    public function getAuthInfo($flag=false){        
        if($flag){
            $auth_info=$this->order('auth_path asc')->select();
        }else{
            $auth_info=$this->where('auth_level<2')->order('auth_path asc')->select();
        }
        foreach($auth_info as $key=>$value){
            $auth_info[$key]['auth_name']=str_repeat('-->>',$value['auth_level']).$value['auth_name'];
        }
        return $auth_info;
    }

    /*
    *数据插入之前做处理
    **/
    private function insertBefore($pData,$auth_id){
        if(!$pData['auth_pid']==0){//不是顶级权限
            $pinfo=$this->find($pData['auth_pid']);//查找上级权限全路径
            $auth_path=$pinfo['auth_path'].'-'.$auth_id;
        }else{
            $auth_path=$auth_id;
        }   
        $auth_level=count(explode('-',$auth_path))-1;
        $pData['auth_id']=$auth_id;
        $pData['auth_path']=$auth_path;
        $pData['auth_level']=$auth_level;
        return $pData;
    }

}