<?php 

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

$record=mysqli_query($db,'SELECT drink_table.*,stock_table.stock FROM drink_table JOIN stock_table ON drink_table.drink_id=stock_table.drink_id');
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

if(isset($_SESSION['id'])&& $_SESSION['time']+3600>time()){
    //ログインしている
    $_SESSION['time']=time();
    
    $sql=sprintf('SELECT * FROM members WHERE id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
    
    $record=mysqli_query($db,$sql)or die(mysqli_error($db));
    $member=mysqli_fetch_assoc($record);
}else{
    //ログインしていない
    header('Location: ../login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
 <head>
     <meta charset="UTF-8">
     <title>管理画面</title>
     <style>
         table,tr,th,td{
             border:solid 1px;
         }
     </style>
 </head>    
 <body>
     <h1>ECsite管理ツール</h1>
     <div style="text-align:right"><a href="../login/logout.php">ログアウト</a></div>
     <a href="tool.php">アカウント情報一覧はこちらで</a>
    
   <?php 

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

$record=mysqli_query($db,'SELECT drink_table.*,stock_table.stock FROM drink_table JOIN stock_table ON drink_table.drink_id=stock_table.drink_id');
////JOIN stock_table ON drink_table.drink_id=stock_table.drink_id


?>

<!DOCTYPE html>
<html lang="ja">
 <head>
     <meta charset="UTF-8">
     <title>管理画面</title>
     <style>
         table,tr,th,td{
             border:solid 1px;
         }
     </style>
 </head>    
 <body>
     <h1>自動販売機管理ツール</h1>
     
     
     
    <section>
        <h2>新規商品追加</h2>
        <form method="post" enctype="multipart/form-data" action="practice_do.php">
         
            <div>名前<input type="text" name="drink_name" id="drink_name"></div>
            <div>値段<input type="text" name="value" id="value"></div>
            <div>個数<input type="text" name="stock" id="stock"></div>
            
            <div>
                <input type="file" name="product_image" id="product_image"></div>
            
            <div>
                <select name="open_status" id="open_status">
                    <option value="2" name="2" id="2">選択してください。</option>
                    <option value="0" name="0" id="0">非公開</option>
                    <option value="1" name="1" id="1">公開</option>
                    <option value="3" name="3" id="3">テスト用</option>
                </select>
            </div>
            <div><input type="submit" name="submit" value="商品追加"></div>
            <input type="hidden" name="submit_type" value="add_item">
        
        </form>
    </section>
    
    <section>
        <h2>商品情報変更</h2>
        <caption>商品一覧</caption>
        <table>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>ステータス</th>
                <th>削除</th>
            </tr>
            <?php while($table=mysqli_fetch_assoc($record)){ ?>
            <tr>
                <td> <img width="100" height="100" src="<?php print($table['product_image']) ?>"> </td>
                <td><?php print($table['drink_name']);?></td>
                <td><?php print($table['value']);?></td>
                
                
                <!---在庫数変更フォーム--->
                <form method="post" action="practice_stock.php">
                    <td>
                        <input type="text" name="stock" value="<?php print($table['stock']); ?>"> 
                        <input type="hidden" name="drink_id" value="<?php print($table['drink_id'])?>">
                        <input type="hidden" name="submit_type" value="change_value">
                        <input type="submit" value="変更">
                    </td>
                </form>
                
                 

                <!---ステータス変更フォーム--->
                
                <form method="post" action="practice_status.php">
                    <td>
                        <?php if((int)($table['open_status'])===0){ ?>
                        <input type="submit" name="change_status" value='非公開->公開'>
                        
                        <?php }else{ ?>
                        
                        <input type="submit" name="change_status" value='公開->非公開'>
                        
                        <?php } ?>
                        <input type="hidden" name="open_status" value="<?php print($table['open_status']); ?>">
                        <input type="hidden" name="drink_id" value="<?php print($table['drink_id']); ?>">
                        <input type="hidden" name="submit_type" value="change_status">
                    </td>
                </form>
            
                <!--商品情報削除フォーム-->
                <form method="post" action="practice_delete.php">
                    <td>
                        <?php if(($table['drink_id'])!=""){ ?>
                        <input type="submit" name="delete" value="削除">
                        <input type="hidden" name="drink_id" value="<?php print($table['drink_id']); ?>">
                        <?php }  ?>
                    </td>
                </form>
            </tr>
            <?php } ?>
        </table>
    </section>
 </body>
</html>