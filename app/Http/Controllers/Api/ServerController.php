<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Name;

class ServerController extends Controller
{
    public function decrypt()
    {
        $data = base64_decode($_GET['data']);
        $method='AES-256-CBC';
        $key='1905api';
        $iv='WUSD8796IDjhkchd';

        //解密
        $dec_data=openssl_decrypt($data, $method, $key,OPENSSL_RAW_DATA,$iv);
        echo "解密数据".$dec_data;
    }

    public function rsa1()
    {
        $priv_key = file_get_contents(storage_path('keys/priv.key'));
        $data = "helloworld";
        echo "原文".$data;echo "<hr>";
        //加密
        openssl_private_encrypt($data,$enc_data,$priv_key);
        echo "加密后".$enc_data;echo "<hr>";
        //将密文发送至对方
        $base64_encode_str = base64_encode($enc_data);//密文经过base64编码
        $url = 'http://server.1905.com/rsadescypt1?data='.urlencode($base64_encode_str);
        $a=file_get_contents($url);
        echo $a;

//        $pub_key=file_get_contents(storage_path('keys/pub.key'));
//        openssl_public_decrypt($enc_data,$dec_data,$pub_key);echo 123;
//        echo $dec_data;


    }

    public  function  rsadescypt1()
    {
        $enc_data_str = $_GET['data'];
        $base64 = base64_decode($enc_data_str);
        $pub_key=file_get_contents(storage_path('keys/pub.key'));
        openssl_public_decrypt($base64,$data,$pub_key);
        echo $data;
    }

    public  function  info()
    {
        echo phpinfo();
    }

    public function curl1(){
        $url="http://1905api.comcto.com/test/curl1?name=huoshiaho&sex=nan&age=24";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_exec($ch);
        curl_close($ch);
    }
    public function curl2(){
        $url="http://1905api.comcto.com/test/curl2";
        $data=[
            'name'=>'huoshihao',
            'sex'=>2,
            'age'=>24
        ];

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);



        curl_exec($ch);
        curl_close($ch);
    }
    public function curl3(){
        $url="http://1905api.comcto.com/test/curl3";
        $data=[
            'img'=>new \CURLFile('qq.png')
        ];
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);



        curl_exec($ch);
        curl_close($ch);



    }
    public function curl4(){
        $url="http://1905api.comcto.com/test/curl4";
        $data=[
            'name'=>'huoshihao',
            'sex'=>2,
            'age'=>24
        ];
        $post_json=json_encode($data);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_json);
        curl_setopt($ch,CURLOPT_HTTPHEADER,[
            'Content-Type:text/plain',
            'token:'.'12345678901234567890'
        ]);



        curl_exec($ch);
        curl_close($ch);
    }

    public  function  add2()
    {
        $flight = new Name;
        $flight->user = "qwe";
        $flight->save();
    }
}
