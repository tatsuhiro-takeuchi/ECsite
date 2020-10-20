<?php 
require('dbconnect.php');
session_start();
error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
$name=$_POST['name'];
$password=$_POST['password'];
$limit=6;
$nameLength = strlen($name);
$passwordLength = strlen($password);

////同一名制限
$sql=sprintf('SELECT COUNT(*) AS cnt FROM members WHERE name="%s"',
 mysqli_real_escape_string($db,$_POST['name']));
$record=mysqli_query($db,$sql)or die(mysqli_error($db));
$table=mysqli_fetch_assoc($record);

if(!empty($_POST)){
//エラー項目の確認
//文字数制限
 if($limit > $nameLength){
  $error['name']='length';}
//半角英数字制限
 elseif(preg_match("/^[a-zA-Z0-9]+$/", $name)==false){
  $error['name']='limit';}
//空白制限
 elseif($_POST['name']==''){
  $error['name']='blank';}
//同一名制限
 elseif($table['cnt']>0){
  $error['name']='duplicate';}
//半角英数字制限
 elseif(preg_match("/^[a-zA-Z0-9]+$/", $password)==false){
  $error['password']='limit';}
//文字数制限
 elseif($limit > $passwordLength){
  $error['password']='length';}
//空白制限
 elseif($_POST['password']==''){
  $error['password']='blank';}
 else{
  $_SESSION['join']=$_POST;
 header('Location:check.php');
 exit();}}

//書き直し
if($_REQUEST['action']=='rewrite'){
 $_POST=$_SESSION['join'];
 $error['rewrite']=true;}?>


<p>次のフォームに必要事項を記入ください。</p>
<form action="" method="post">
 <dl><dt>名前<span class="required"></span></dt>
  <dd><input type="text" name="name" size="35" maxlength="255"
       value="<?php echo htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8'); ?>" >
  <?php if($error['name']=='blank'):?>
    <p class="error">*名前を入力してください。</p>
  <?php endif; ?>
  <?php if($error['name']=='limit'):?>
    <p class="error">*名前は半角英数字で登録ください。</p>
  <?php endif; ?></dd>
  <?php if($error['name']=='length'):?>
    <p class="error">*名前は6文字以上で入力してください。</p>
  <?php endif; ?></dd>
  <?php if($error['name']=='duplicate'):?>
    <p class="error">*指定された名前はすでに登録されています。</p>
  <?php endif; ?>
  </dd>
        
  <dt>パスワード<span class="required"></span></dt>
  <dd><input type="password" name="password" size="10"  maxlength="255"
       value="<?php echo htmlspecialchars($_POST['password'],ENT_QUOTES,'UTF-8'); ?>" >
  <?php if($error['password']=='blank'):?>
    <p class="error">*パスワードを入力してください。</p>
  <?php endif; ?></dd>
  <?php if($error['password']=='limit'):?>
    <p class="error">*パスワードは半角英数字で登録ください。</p>
  <?php endif; ?></dd>
  <?php if($error['password']=='length'):?>
    <p class="error">*パスワードは6文字以上で入力してください。</p>
  <?php endif; ?></dd>
    </dl>
     
 <div><input type="submit" value="入力内容を確認する。"></div>
 <a href="../login/login.php">ログイン画面に戻る。</a>
</form>