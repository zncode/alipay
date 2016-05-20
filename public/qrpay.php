<?php 
header("Content-type: text/html; charset=utf-8");
require_once 'F2fpay.php';
require_once '../ext/phpqrcode/phpqrcode.php';

if (!empty($_POST['out_trade_no'])&& trim($_GET['out_trade_no'])!=""){

    $f2fpay = new F2fpay();

    $out_trade_no = trim($_GET['out_trade_no']);
    $total_amount = trim($_GET['total_amount']);
    $subject = trim($_GET['subject']);

    //TODO 生成订单

    $response = $f2fpay->qrpay($out_trade_no,  $total_amount, $subject);
    print_r($response);die();
    //$url = $response->qr_code;
    //QRcode::png($url);
}

?>
