<?php
session_start();
require('dbconnect.php');
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
if(!isset($_SESSION['join'])){
 header('Location:../index.php');
 exit();}
if(!empty($_POST)){
//登録処理する
 $sql=sprintf('INSERT INTO members SET name="%s",password="%s",created="%s"',
 mysqli_real_escape_string($db,$_SESSION['join']['name']),

 mysqli_real_escape_string($db,sha1($_SESSION['join']['password'])),
 date('Y-m-d H:i:s'));
 mysqli_query($db,$sql)or die(mysqli_error($db));
 unset($_SESSION['join']);
 header('Location:thanks.php');
 exit();}?>

<form action="" method="post">
 <input type="hidden" name="action" value="submit">
 <dl>
  <dt>ニックネーム</dt>
   <dd><?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES,'UTF-8');?> </dd>
  <dt>パスワード</dt>
   <dd>【表示されません。】</dd>
 <div><a href="entry.php?action=rewrite">書き直す</a>
 <input type="submit" value="登録する"></div>
</form>