<?php 

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名

$values=0;
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

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
    
    $record=mysqli_query($db,'SELECT * FROM cart JOIN drink_table ON cart.drink_id=drink_table.drink_id JOIN stock_table ON cart.drink_id=stock_table.drink_id
WHERE user_id='.$_SESSION['id']);

?>

<!DOCTYPE html>
<html>
    <head lang="ja">
        <title>カート機能</title>
        <meta charset="UTF-8">
         <style>
         table,tr,th,td{
             border:solid 1px;
         }
         </style>
    </head>
    
    <body>
        <header>
            <h1>カート内一覧</h1>
        </header>
        <div class="cart">
            <div style="text-align:right"><a href="../login/logout.php">ログアウト</a></div>
            <form action="result.php">
            <input type="submit" value="購入">
            <table>
            <tr>
                <th>画像</th></th>
                <th>商品名</th>
                <th>価格</th>
                <th>購入数</th>
                <th>削除</th>
            </tr>
            
            <?php while($table=mysqli_fetch_assoc($record)){ ?>
            <tr>
            　　<td> <img width="100" height="100" src="../tool/<?php print($table['product_image']) ?>"> </td>
                <td><?php print($table['drink_name']);?></td>
                <td><?php print($table['value']);?></td>
                <input type="hidden" name="amount" value="<?php print($table['amount']);?>"> 
                <?php $values+=($table['value']*$table['amount']); ?>
                </form>
                <!---購入数変更フォーム--->
                <form method="post" action="cart_amount.php">
                <td>
                <input type="text" name="amount" value="<?php print($table['amount']);?>"> 
                <input type="hidden" name="id" value="<?php print($table['id']);?>">
                <input type="submit" value="変更">
                </td>
                </form>
                <!---削除機能--->
                <td>
                <form method="post" action="cart_delete.php">
                <?php if((int)($table['id'])!=0){ ?>
                <input type="submit" name="delete" value="削除">
                <input type="hidden" name="id" value="<?php print(htmlspecialchars($table['id'])); ?>">
                <?php }  ?>
                </form>
                </td>
            </tr>
            <?php } ?>
             </table>
             </div>
             <p>合計：<?php print($values); ?></p>
             <a href="index.php">商品一覧に戻る</a>
           </body>
           </html>