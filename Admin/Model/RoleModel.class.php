<?php

namespace Admin\Model;
use Think\Model;


class RoleModel extends Model{

    public function addRole($pData){
        $pData['role_auth_ids']=implode(',',$pData['role_auth_ids']);
        $auth_info=D('auth')->select($pData['role_auth_ids']);
        foreach($auth_info as $key){
            if(!!$key['auth_c']&&!!$key['auth_a'])
            $pData['role_auth_ca'].=$key['auth_c'].'-'.$key['auth_a'].',';
        }
        $pData['role_auth_ca']=rtrim($pData['role_auth_ca'],',');
        return $this->add($pData);
    }

}