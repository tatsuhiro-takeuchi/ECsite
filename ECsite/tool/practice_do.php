<?php 

$host = 'localhost'; // データベースのホスト名又はIPアドレス ※CodeCampでは「localhost」で接続できます
$username = 'codecamp38173';  // MySQLのユーザ名
$passwd   = 'codecamp38173';    // MySQLのパスワード
$dbname   = 'codecamp38173';    // データベース名
$db=mysqli_connect($host,$username,$passwd,$dbname)or
 die(mysqli_connect_error());
 mysqli_set_charset($db,'utf8');

error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);

$file=$_FILES['product_image'];

//ファイルのアップロード処理
$ext1=substr($file['name'],-4);
$ext2=substr($file['name'],-5);

//入力漏れ処理
$value=$_POST['value'];
$stock=$_POST['stock'];
if(empty($file['name']) || empty($_POST['drink_name']) || !strlen($_POST['stock']) ||
  !strlen($_POST['value']) ){
  print'入力漏れがあります。';    
}elseif($stock!=0 && $stock=filter_input(INPUT_POST,"stock",FILTER_VALIDATE_INT,["options"=>["min_range"=>1]])==false){
  print'在庫数は整数を入力ください';
}elseif($value!=0 &&$value=filter_input(INPUT_POST,"value",FILTER_VALIDATE_INT,["options"=>["min_range"=>1]])==false){
  print'価格は整数を入力ください';}
elseif(($_POST['open_status'])!=="0"&&($_POST['open_status'])!=="1"){
  print'公開、非公開以外のステータスの場合、商品追加できません';}
elseif($ext1==='.jpg'||$ext1==='.png'||$ext2==='.jpeg'||$ext1==='.jpe'){
  $filePath=''.$file['name'];
  move_uploaded_file($file['tmp_name'],$filePath);
  print('<img src="'.$filePath.'">');
    
  $sql=sprintf('INSERT INTO drink_table SET product_image="%s",drink_name="%s",value=%d,open_status=%d',
    mysqli_real_escape_string($db,$file['name']),
    mysqli_real_escape_string($db,htmlspecialchars($_POST['drink_name'])),
    mysqli_real_escape_string($db,$_POST['value']),
    mysqli_real_escape_string($db,$_POST['open_status']));
    mysqli_query($db,$sql)or die(mysqli_error($db));

  $sql2=sprintf('INSERT INTO stock_table SET stock="%s"',
    mysqli_real_escape_string($db,$_POST['stock']));
    mysqli_query($db,$sql2)or die(mysqli_error($db));
    print'データ登録完了';
  }else{
    print'※拡張子が.jpg,.pngのいずれかのファイルをアップロードしてください';}?>


<HTML>
<HEAD>
<TITLE>ジャンプ</TITLE>
<!--<META http-equiv="Refresh" content="1;URL=practice.php">-->
</HEAD>
<BODY>
<a href="practice.php">管理一覧に戻る</a>

</BODY>

