<?php 

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

$record=mysqli_query($db,'SELECT name,created FROM members;');
////JOIN stock_table ON drink_table.drink_id=stock_table.drink_id
?>

<?php
session_start();

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
    //ログインしている
    $_SESSION['time']=time();
    
    $sql=sprintf('SELECT * FROM members WHERE id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
    
    $record2=mysqli_query($db,$sql)or die(mysqli_error($db));
    $member=mysqli_fetch_assoc($record2);
}else{
    //ログインしていない
    header('Location: ../login/login.php');
    exit();
}?>

<!DOCTYPE html>
<html lang="ja">
 <head>
     <meta charset="UTF-8">
     <title>ユーザー管理画面</title>
     <style>
         table,tr,th,td{
             border:solid 1px;
         }
     </style>
 </head>    
 <body>
     <h1>ECsite管理ツール</h1>
     <div style="text-align:right"><a href="../login/logout.php">ログアウト</a></div>
     <a href="practice.php">商品情報変更はこちらで</a>
     
    <section>
        <h2>アカウント情報一覧</h2>
        <caption>アカウント情報</caption>
        <table>
            <tr>
                <th>氏名</th>
                <th>登録日時</th>
            </tr>
            <?php while($table=mysqli_fetch_assoc($record)){ ?>
            <tr>
                <td><?php print(htmlspecialchars($table['name']));?></td>
                <td><?php print(htmlspecialchars($table['created']));?></td>
            </tr>
            <?php } ?>
        </table>
    </section>
 </body>
</html>