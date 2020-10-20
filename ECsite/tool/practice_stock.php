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
?>
<HTML>
<HEAD>
<TITLE>ジャンプ</TITLE>

</HEAD>
<BODY>
<?php 
 $drink_id = (int)$_POST['drink_id'];
 $update_stock = (int)$_POST['stock'];
                if(isset($_POST['stock'])){
                   if($update_stock=filter_input(INPUT_POST,"stock",FILTER_VALIDATE_INT,["options"=>["min_range"=>0]])===false){
                       print'在庫数は正の整数でお願いします。';
                   } else{                   
                    $sql = 'UPDATE stock_table SET stock = ' . $_POST['stock']. ' WHERE drink_id = ' . $drink_id; 

                    if(mysqli_query($db,$sql) === TRUE){
                        $success_msg [] = '在庫変更成功';
                        print'在庫変更成功';
                    }else{
                        $err_msg[] = 'UPDATE stock_table:updateエラー:' . $sql;
                        print'在庫変更失敗1';
                    }
                }}else{
                    $err_msg[] = '在庫変更失敗';  
                    print'在庫変更失敗2';
                }
                ?> 
    <a href="practice.php">商品管理一覧に戻る。</a>

</BODY>

