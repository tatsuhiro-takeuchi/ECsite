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

error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
 $drink_id = (int)$_POST['drink_id'];
 
                if(($_POST['change_status']) ==='公開->非公開'){
                    $sql = 'UPDATE drink_table SET open_status = 0  WHERE drink_id = ' . $drink_id; 
                    if(mysqli_query($db,$sql) === TRUE){
                        $success_msg [] = 'ステータス変更成功'; 
                        print'ステータス変更成功';
                    }else{
                        $err_msg[] = 'UPDATE drink_table:updateエラー:' . $sql;
                    }}elseif(($_POST['change_status']) === '非公開->公開') {
                    $sql = 'UPDATE drink_table SET open_status = 1  WHERE drink_id = ' . $drink_id; 
                    if(mysqli_query($db,$sql) === TRUE){
                        $success_msg [] = 'ステータス変更成功'; 
                        print'ステータス変更成功';
                    }else{
                        $err_msg[] = 'UPDATE drink_table:updateエラー:' . $sql;
                        print'ステータス変更失敗';
                    }
                }

?>
<HTML>
<HEAD>
<TITLE>ジャンプ</TITLE>

</HEAD>
<BODY>
<a href="practice.php">商品管理画面に戻る。</a>

</BODY>
