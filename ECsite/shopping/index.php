<?php 
//データベース接続
$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
    die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');
$recordSet=mysqli_query($db,'SELECT * FROM drink_table,stock_table WHERE drink_table.drink_id=stock_table.drink_id AND open_status=1');
//エラー処理
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
//ログイン機能
session_start();
if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
//ログインしている
  $_SESSION['time']=time();
  $sql2=sprintf('SELECT * FROM members WHERE id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
  $record2=mysqli_query($db,$sql2)or die(mysqli_error($db));
  $member=mysqli_fetch_assoc($record2);
}else{
//ログインしていない
  header('Location: ../login/login.php');
  exit();}

//「カートに入れる」押下時の処理
//エラーがない場合
if(empty($error)){
  //SQL3にある選択したドリンクIDの数を計算
  $sql3=sprintf('SELECT COUNT(*) AS cnt FROM cart WHERE drink_id=%d AND user_id='.$_SESSION['id'],
    mysqli_real_escape_string($db,$_POST['drink_id']));
  $record3=mysqli_query($db,$sql3) or die(mysqli_error($db));
  $table1 =mysqli_fetch_assoc($record3);
  if($table1['cnt']>0){
    $error['drink_id']='duplicate';}}

if($error['drink_id']==='duplicate'){
  $sql2=sprintf('UPDATE cart SET amount = amount +1 WHERE user_id=%d AND drink_id= %d', 
    mysqli_real_escape_string($db,$_POST['id']),
    mysqli_real_escape_string($db,$_POST['drink_id']));
    mysqli_query($db,$sql2)or die(mysqli_error($db));    
}elseif(!empty($_POST)){
    $sql2=sprintf('INSERT INTO cart SET user_id=%d,drink_id=%d,amount=%d ON DUPLICATE KEY UPDATE drink_id=VALUES(drink_id),amount=amount+1', 
      mysqli_real_escape_string($db,$_POST['id']),
      mysqli_real_escape_string($db,$_POST['drink_id']),
      mysqli_real_escape_string($db,1));
      mysqli_query($db,$sql2)or die(mysqli_error($db));}?> 

<!DOCTYPE html>
<html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>shopping</title>
  <style>
    table,tr,th,td{
     border:solid 1px;}
  </style>
 </head>
 <body>
  <h1>shop</h1>
  <p><a href="cart.php">カートへ移動</a></p>
  <div style="text-align:right"><a href="../login/logout.php">ログアウト</a></div>
  <table>   
  <tr>
  <?php while($table=mysqli_fetch_assoc($recordSet)){ ?>
   <form method='POST'　action="index.php">
  <?php $drink_name=$table['drink_name'];?>
   <td><img width="100" height="100" name="product_image" src="../tool/<?php print($table['product_image']) ?>"> <br>
  <?php print($table['drink_name']);?><br>
  <?php echo $table['value'];?>
   <input type="hidden" name=drink_id value=<?php print($table['drink_id']); ?>>
   <input type="hidden" name="id" value=<?php print($_SESSION['id']) ?>>
  <?php if((int)$table['stock']===0){?> 
   <p>売り切れ</p>
  <?php }else{ ?>
   <input type='submit' name="selected_drink" value="カートに入れる">
   </form>
  <?php }} ?></td> </tr>
   <input type="hidden" name="value" value=<?php print($table['value']) ?>>
   <input type="hidden" name="stock" value=<?php print($table['stock']) ?>>
  </table>
 </body>
</html>
