<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '1234';
$DATABASE_NAME = 'filesystem';
$a=true;
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
 echo "<body style='background-color:#595959'>";
 
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

    $id = mysqli_real_escape_string($con , $_POST['userid']);
	$username = mysqli_real_escape_string($con , $_POST['username']);
	$password = mysqli_real_escape_string($con , $_POST['password']);
	$type = mysqli_real_escape_string($con , $_POST['usertype']);
	
 if (empty($username) || empty($id) || empty($password) || empty($type)){
	 echo '<link href="style.css" rel="stylesheet" type="text/css">
		<style>
.container {
  height: 200px;
    width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
}
</style>
<div class="container">
  <center>Boş Kutuları Doldurunuz
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=profile.php">';
 }
  $user_check = "SELECT * FROM users WHERE nameuser='$username' OR iduser='$id' LIMIT 1";
  $result = mysqli_query($con, $user_check);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['nameuser'] === $username) {
      echo '<link href="style.css" rel="stylesheet" type="text/css">
		<style>
.container {
  height: 200px;
    width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
}
</style>
<div class="container">
  <center>Aynı Kullanıcı Mevcut
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=profile.php">';
$a=false;
    }
  
    if ($user['iduser'] === $username) {
      echo '<link href="style.css" rel="stylesheet" type="text/css">
		<style>
.container {
  height: 200px;
    width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
}
</style>
<div class="container">
  <center>Aynı ID Mevcut
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=profile.php">';
    }
	$a=false;
  }
 if ($type!="Yönetici" &&  $type!="Kullanıcı"){
	 echo '<link href="style.css" rel="stylesheet" type="text/css">
		<style>
.container {
  height: 200px;
    width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
}
</style>
<div class="container">
  <center>Kullanıcı Tipini Kontrol Ediniz
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=profile.php">';
$a=false;
 }
 if($a==true){
$sql = "INSERT INTO users (iduser ,nameuser, passuser, typeuser)
VALUES ('$id' ,'$username', '$password', '$type')";
 }
if (mysqli_query($con, $sql) && $a==true) {
  echo '<link href="style.css" rel="stylesheet" type="text/css">
		<style>
.container {
  height: 200px;
    width: 400px;

    position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px;
}
</style>
<div class="container">
  <center>Kayıt Başarılı
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=profile.php">';
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

	
?>