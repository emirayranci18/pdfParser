<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '1234';
$DATABASE_NAME = 'filesystem';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
 echo "<body style='background-color:#595959'>";
if ( mysqli_connect_errno() ) {

	exit('MYSQL bağlantı hatası ' . mysqli_connect_error());
}

if ( !isset($_POST['username'], $_POST['password']) ) {

	exit('Tüm Boşlukları Doldurunuz!');
}
if ($stmt = $con->prepare('SELECT iduser, passuser,typeuser FROM users WHERE nameuser = ?')) {

	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();

	$stmt->store_result();
if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password, $type);
	$stmt->fetch();

	if ($_POST['password'] === $password) {

		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['username'];
		$_SESSION['id'] = $id;
		echo 'Welcome ' . $_SESSION['name'] . '!';
		if ('Yönetici' === $type){
		header("Location: profile.php");
		}
		else if ('Kullanıcı' === $type){
		header("Location: home.php");
		}
	} else {
		// Incorrect password
		echo '
		<link href="style.css" rel="stylesheet" type="text/css">
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
  <center>Kullanıcı Adı Veya Şifre Yanlış
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=index.html">';
	}
} else {
	// Incorrect username
	echo '
	<link href="style.css" rel="stylesheet" type="text/css">
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
  <center>Kullanıcı Adı Veya Şifre Yanlış
    </div>
</div>
<META HTTP-EQUIV="Refresh" CONTENT="2; URL=index.html">';
}

	$stmt->close();
}
?>