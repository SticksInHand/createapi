<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	    $Data = M("home_product_details");
        $this->data = $Data->select();
        $this->display();
    }
    public function detail(){
        $id = I('id');
        $this->id = $id;
        $Data = M("home_product_details");
        $this->data = $Data->where('product_id='.$id)->select();
        $this->display();
    }
}