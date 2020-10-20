<?php 
$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
 die(mysqli_connect_error());
 mysqli_set_charset($db,'utf8');
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

//ログイン機能
session_start();
if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
//ログインしている
 $_SESSION['time']=time();
 $sql2=sprintf('SELECT * FROM members WHERE id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
 $record2=mysqli_query($db,$sql2)or die(mysqli_error($db));
 $member=mysqli_fetch_assoc($record2);}else{
//ログインしていない
 header('Location: ../login/login.php');
 exit();}

$record=mysqli_query($db,'SELECT * FROM cart JOIN drink_table ON cart.drink_id=drink_table.drink_id JOIN stock_table ON cart.drink_id=stock_table.drink_id
    WHERE user_id='.$_SESSION['id']);
$record3=mysqli_query($db,'SELECT * FROM cart JOIN drink_table ON cart.drink_id=drink_table.drink_id JOIN stock_table ON cart.drink_id=stock_table.drink_id; ');

//購入時の在庫数処理・カート内削除処理
while($table=mysqli_fetch_assoc($record3)){
  $id=$table['id'];
  $drink_id=$table['drink_id'];
  $stock=$table['stock'];
  $value=$table['value'];
  $amount=$table['amount'];
  $stocks=$stock-$amount;
  $values=0;
  $total="";
  $thanks1="";
  $thanks2="";

  if($stock<$amount){
   $thanks1='申し訳ございません、在庫がございません';
  }elseif($table['open_status']!=1){
   $thanks1='申し訳ございません、非公開商品です。';}
  elseif($stock>=$amount){
   $sql = 'UPDATE stock_table SET stock =' . $stocks . ' WHERE drink_id = ' . $drink_id;
   $record4=mysqli_query($db,$sql);
   $thanks1='ご利用ありがとうございました。';
   $thanks2='商品を購入しました。';
   $total='合計';
   $delete='DELETE FROM cart WHERE id='.$id;
   $record5=mysqli_query($db,$delete);}}?>

<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charaset="UTF-8">
  <title>購入結果</title>
  <style>
   table,tr,th,td{
   border:solid 1px;}
  </style>
  </head>
 <body>
  <?php print($thanks1);?>
  <?php print($thanks2);?>

  <table>
   <tr>
　  <th>画像</th>
　  <th>商品名</th>
　  <th>価格</th>
　  <th>購入数</th>
　  <th>合計額</th>
   </tr>
 <?php while($table=mysqli_fetch_assoc($record)){ ?>
 　<td> <img width="100" height="100" src="../tool/<?php print($table['product_image']) ?>"> </td>
 　<td><?php print($table['drink_name']);?></td>
 　<td><?php print($table['value']);?></td>
 　<td><?php print($table['amount']);?> </td>
 　<td><?php print($table['value']*$table['amount']);?> </td>
 　<?php $values+=($table['value']*$table['amount']); ?>
</tr><?php } ?>
 <h2><?php print($total);?>
     <?php print($values);?></h2>
 <a href="index.php">商品一覧に戻る</a>
 </body>
</html>