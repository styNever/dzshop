<?php

namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model{

    /**
    *删除上传的文件*
    **/

    public function delImg($goodsId){
        $imgFile=$this->where('goods_id='.$goodsId)->getField('goods_big_img,goods_small_img');
        foreach($imgFile as $bigImg=>$smallImg){
            $bigImg=explode(',',$bigImg);
            foreach($bigImg as $file){
                $file='.'.$file;
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $smallImg=explode(',',$smallImg);
            foreach($smallImg as $file){
                $file='.'.$file;
                if(file_exists($file)){
                    unlink($file);
                }
            }            
        } 
    }
}