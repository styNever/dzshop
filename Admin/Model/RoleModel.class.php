<?php

namespace Admin\Model;
use Think\Model;


class RoleModel extends Model{
    /*
    *添加角色处理*
    */
    public function addRole($pData){
        $pData=$this->beforeToDB($pData);
        return $this->add($pData);
    }
    /*
    *删除角色处理*
    */    
    public function delRole($roleId){
        $hasManagers=M('manager')->where('role_id='.$roleId)->select();
        if($hasManagers){
            return false;
        }else{
            return $this->delete($roleId);
        }
    }
    /*
    *更新角色处理*
    */
    public function updateRole($pData){
        $pData=$this->beforeToDB($pData);
        return $this->save($pData);
    }
    /*
    *存储到数据库之前数据处理*
    */
    private function beforeToDB($pData){
        $pData['role_auth_ids']=implode(',',$pData['role_auth_ids']);
        $auth_info=D('auth')->select($pData['role_auth_ids']);
        foreach($auth_info as $key){
            if(!!$key['auth_c']&&!!$key['auth_a'])
            $pData['role_auth_ca'].=$key['auth_c'].'-'.$key['auth_a'].',';
        }
        $pData['role_auth_ca']=rtrim($pData['role_auth_ca'],',');
        return $pData;
    }

}