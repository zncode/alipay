<?php
require_once('../aop/AopClient.php');
require_once('../config.php');

//notify_url.php
//
// $post_data = $GLOBALS['HTTP_RAW_POST_DATA'];
$post_data = file_get_content("php://input");

//去除sign、sign_type
//unset($post_data('sign'));
//unset($post_data('sign_type'));

//验证是否是支付宝请求
$notify_id_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner=2088002396712354&notify_id=RqPnCoPT3K9%252Fvwbh3I%252BFioE227%252BPfNMl8jwyZqMIiXQWxhOCmQ5MQO%252FWd93rvCB%252BaiGg';
$resp = AopClient::curl($notify_id_url);

if($resp)
{
    //验签
    $sign_1 = $post_data['sign'];
    $sign_2 = AopClient::generateSign($post_data);

    //读取公钥文件
    $pubKey = file_get_contents($config['alipay_public_key_file']);

    //转换为openssl格式密钥
    $pubKey = openssl_get_publickey($pubKey);

    //调用openssl内置方法验签，返回bool值
    $result = (bool)openssl_verify($sign_1, $sign_2, $pubKey);

    //释放资源
    openssl_free_key($pubKey);

    if($result)
    {
        //TODO 发货
        //TODO 更新订单状态

        echo 'success';die();
    }
}

