//ログイン機能
<?php require('db.php');
 session_start();
 error_reporting(E_ALL & ~ E_DEPRECATED & ~ E_USER_DEPRECATED & ~ E_NOTICE);
 if($_COOKIE['name']!=''){
    $_POST['name']=$_COOKIE['name'];
    $_POST['password']=$_COOKIE['password'];
    $_POST['save']='on';}

 if(!empty($_POST)){
   //ログインの処理
   if($_POST['name']!='' && $_POST['password']!=''){
     $sql=sprintf('SELECT * FROM members WHERE name="%s" AND password="%s"',
          mysqli_real_escape_string($db,$_POST['name']),
          mysqli_real_escape_string($db,sha1($_POST['password'])));
     $record=mysqli_query($db,$sql) or die(mysqli_connect_error($db));
   if($table=mysqli_fetch_assoc($record)){
     //ログイン成功
     $_SESSION['id']=$table['id'];
     $_SESSION['time']=time();
     //ログイン情報を記録する。
    if($_POST['name']==='admin' && $_POST['password']==='admin'){
     setcookie('name',$_POST['name'],time()+60*60*24*14);
     setcookie('password',$_POST['password'],time()+60*60*24*14);
     header('Location:../tool/practice.php');
     exit();
   }else{
     setcookie('name',$_POST['name'],time()+60*60*24*14);
     setcookie('password',$_POST['password'],time()+60*60*24*14);
     header('Location:../shopping/index.php');
     exit();}}
    else{
     $error['login']='failed';
  }}else{$_error['login']='blank';}}?>

<div id="lead">
 <p>名前とパスワードを入力してログインお願いします。</p>
 <p>入会手続きがまだの方はこちらをどうぞ</p>
 <p>&raquo;<a href="../entry/entry.php">入会手続きをする</a></p>
</div>
<form action="" method="post">
 <dl>
  <dt>名前</dt>
  <dd>
   <input type="text" name=name size="35" maxlength="255" 
          value="<?php echo htmlspecialchars($_POST['name']); ?>">
  <?php if($error['login']=='blank'): ?>
     <p class="error">名前とパスワードをご記入してください。</p>
  <?php endif; ?>
  <?php if($error['login']=='failed'): ?>
     <p class="error">*ログインに失敗しました。正しくご記入ください。</p>
  <?php endif; ?>.  
  </dd>
   <dt>パスワード</dt>
  <dd>
   <input type="password" name="password" size="35" maxlength="255" 
        value="<?php echo htmlspecialchars($_POST['password']);?>"/> 
  </dd>
   <dt>ログイン情報の記録</dt>
  <dd>
   <input id="save" type="checkbox" name="save" value="on">
   <label for="save">次回から自動的にログインする</label>
  </dd></dl>
   <div><input type="submit" value="ログインする"/></div>
 </form>