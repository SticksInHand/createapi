<?php
/**
 * Created by PhpStorm.
 * User: M.Jin
 * Date: 14-8-12
 * Time: 下午4:11
 */
class ApiAction extends Action{
    public function form(){
        $this->display();
    }
    public function insert(){

        $Data_api = D('api');
        $Data_request = D('request');
        $Data_back = D('back');

        //取得表单提交数据
        $model_id = I('model_id');//所属模块儿id
        $api_name = I('api_name');//接口名称
        $api_info = I('api_info');//接口简介
        $api_accept = I('api_accept');//是否授权
        $back_content = I('back_content');//返回结果
        $request_string = trim(I('request_string'));//请求参数字符串
        $back_string = trim(I('back_string'));//返回字段字符串


        //将数据存储进api表
        $Data['model_id'] = $model_id;
        $Data['api_name'] = $api_name;
        $Data['api_info'] = $api_info;
        $Data['api_accept'] = $api_accept;
        $Data['back_content'] = $back_content;


        $res = $Data_api->add($Data);

        //对请求参数和返回字段进行处理
        $str1 = explode(";",$request_string);
        $str2 = explode(";",$back_string);


        for($i = 0;$i<=count($str1);$i++){
            if($str1[$i] != ""){
                $array_request = trim($str1[$i]);
                $array1 = explode("/",$array_request);
                $Data1['api_id'] = $res;
                $Data1['request_name'] = $array1[0];
                $Data1['request_if'] = $array1[1] == 'true'?1:0;
                $Data1['request_var'] = $array1[2];
                $Data1['request_detail'] = $array1[3];

                //将解析的数据存储至request表
                $res1 = $Data_request->add($Data1);
            }
        }

        for($j = 0;$j<=count($str2);$j++){
            if($str2[$j] != ""){
                $array_back = trim($str2[$j]);
                $array2 = explode("/",$array_back);
                $Data2['api_id'] = $res;
                $Data2['back_name'] = $array2[0];
                $Data2['back_var'] = $array2[1];
                $Data2['back_detail'] = $array2[2];


                //将解析的数据存入back表
                $res2 = $Data_back->add($Data2);
            }
        }



        $this->display();

    }

    public function showapi($api_id){

        //实例化数据库
        $api = M('api');
        $request = M('request');
        $back = M('back');
        $model = M('model_name');

        //查api表
        $Data1 = $api->where('api_id='.$api_id)->select();
        $this->api_info  = $Data1[0]['api_info'];
        $this->api_name  = $Data1[0]['api_name'];
        $model_id = $Data1[0]['model_id'];
        $Data_model = $model->where('model_id=1')->select();
        $this->model_name = $Data_model[0]['model_name'];
        $this->back_content = $Data1[0]['back_content'];



        $this->data2 = $request->where('api_id='.$api_id)->select();
        $this->data3 = $back->where('api_id='.$api_id)->select();


        $this->display();

    }
    public function showjson(){
        //实例化数据库
        $api = M('api');
        $request = M('request');
        $back = M('back');
        $model = M('model_name');

        $this->api_table = json_encode($api->select());
        $this->request_table = json_encode($request->select());
        $this->back_table = json_encode($back->select());
        $this->model_table = json_encode($model->select());

        $this->display();
    }
}
























