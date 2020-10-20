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
if(($_POST['id']) !=''){
$sql = 'DELETE FROM cart WHERE id='.$id;
  if(mysqli_query($db,$sql) === TRUE){
  $success_msg [] = 'ステータス変更成功'; 
  print('商品削除しました');
  }else{
  $err_msg[] = 'DELETE drink_table:deleteエラー:' . $sql;
  print('商品削除に失敗しました');}}?>
<HTML>
<HEAD>
<TITLE>削除処理</TITLE>
</HEAD>
<BODY>
<a href="cart.php">商品一覧に戻る</a>
</BODY>
</HTML>