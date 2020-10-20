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

 $drink_id = (int)$_POST['drink_id'];
 
                if(($_POST['drink_id']) !=''){
                    $sql = 'DELETE FROM drink_table WHERE drink_id='.$drink_id;
                    $sql2 = 'DELETE FROM stock_table WHERE drink_id='.$drink_id;
                    if(mysqli_query($db,$sql) === TRUE &mysqli_query($db,$sql2) === TRUE){
                        $success_msg [] = 'ステータス変更成功'; 
                        print('商品削除しました');
                    }else{
                        $err_msg[] = 'DELETE drink_table:deleteエラー:' . $sql;
                        print('商品削除に失敗しました');
                    }
                }

?>
<HTML>
<HEAD>
<TITLE>ジャンプ</TITLE>

</HEAD>
<BODY>
<a href="practice.php">商品一覧に戻る</a>


</BODY>
</HTML>