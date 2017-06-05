<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $categorys=M('goods')->distinct(true)->field('category_name')->select();//分类名称
        $allCategorys=M('category')->select();
        $topGoods=M('goods')->where('goods_top=1')->order('goods_selltime desc')->limit(5)->select();//置顶商品
        $goods=M('goods')->order('category_name desc,goods_top desc')->where('goods_top=0')->limit(6)->select();
        foreach($categorys as $category){
            foreach($goods as $key=>$value){
                if($category['category_name']==$value['category_name']){
                    $goodsInfos[$category['category_name']][]=$value;
                }
            }
        }
        $this->assign(array(
            'categorys'=>$categorys,
            'topGoods'=>$topGoods,
            'allCategorys'=>$allCategorys,
        ));
        $this->assign('goodsInfos',$goodsInfos);
        $this->display();
    }
} 