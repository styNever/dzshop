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
        $flag=$this->save($insertData);
        return $this->updateAfter($auth_id,$flag);
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
    public function getAuthInfo($flag=false,$start=0,$num=8){  
        if(session('manager')['role_id']!=1){
            $auth_ids=M('role')->where('role_id='.session('manager')['role_id'])->getField('role_auth_ids');//权限集合              
            if($flag){//获取全部等级权限
                $auth_info=$this->where('auth_id in'." ($auth_ids) ")->order('auth_path asc')->limit($start,$num)->select();                                      
            }else{//获取一二级权限
                $auth_info=$this->where('auth_id in'." ($auth_ids) ")->where('auth_level<2')->order('auth_path asc')->select();
            }
        }else{
            if($flag){//获取全部等级权限
                $auth_info=$this->order('auth_path asc')->limit($start,$num)->select();            
            }else{//获取一二级权限
                $auth_info=$this->where('auth_level<2')->order('auth_path asc')->select();
            }
        }
        foreach($auth_info as $key=>$value){
            $auth_info[$key]['auth_name']=str_repeat('-->>',$value['auth_level']).$value['auth_name'];
        }
        return $auth_info;
    }

    /*
    *数据插入之前做处理
    *对插入的数据做格式化处理，得到权限的pid和权限全路径
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

    /**
    *权限更新后更新子权限全路径*
    **/
    private function updateAfter($auth_id,$flag=false){
        if(!$flag){//如果父级更新失败怎么退出
            return $flag;
        }
        $pPath=$this->where('auth_id = '.$auth_id)->getField('auth_path');//得到更新后的权限全路径
        $childAuths=$this->where('auth_pid = '.$auth_id)->select();
        foreach($childAuths as $key=>$value){
            $childAuths[$key]['auth_path']=$pPath.'-'.$value['auth_id'];
            if(!$this->save($childAuths[$key])){
                $flag=false;
            }
        }
        return $flag;
    }
}