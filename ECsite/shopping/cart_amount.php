<?php 
$err_msg = array();
$success_msg = array();
$drink_name = '';
$price = 0;
$stock = 0;
$status = 0;
$file_name ='';
$drink_id = 0;
$ext = '';
$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

//error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
 $id = (int)$_POST['id'];
 $update_amount = (int)$_POST['amount'];
 if($update_amount=filter_input(INPUT_POST,"amount",FILTER_VALIDATE_INT,["options"=>["min_range"=>1]])==false){
print'購入数は正の整数を入力ください';}
 elseif(isset($_POST['amount'])){
   $sql = 'UPDATE cart SET amount ='.$_POST['amount'].' WHERE id ='.$_POST['id']; 
   if(mysqli_query($db,$sql) === TRUE){
   $success_msg [] = '購入数変更成功'; 
   print('購入数変更に成功しました。');
   }else{
   $err_msg[] = 'UPDATE cart:updateエラー:' . $sql;
   }}else{
   $err_msg[] = '購入数変更失敗';   
   print('購入数変更に失敗しました。');}?>
<HTML>
<HEAD>
<TITLE>ジャンプ</TITLE>
<META http-equiv="Refresh" content="1;URL=cart.php">
</HEAD>
<BODY>
</BODY>
</HTML>

