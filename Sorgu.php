<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '1234';
$DATABASE_NAME = 'filesystem';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT passuser, typeuser FROM user WHERE iduser = ?');

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="style2.css" rel="stylesheet" type="text/css">
		<title>Profile Page</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>File Check<br/>Admin Menu<br/>Sorgu 1</h1>
				<td>Mevcut Kullanıcı:</td>
						<td><?=$_SESSION['name']?></td>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
				<a href="profile.php"><i class="fas fa-asterisk"></i>Kullanıcı Ekle</a>
				<a href="Sorgulama.php"><i class="fas fa-archive"></i>Sorgu 2</a>
			</div>
		</nav>
		<div class="login">
			<h1>Derse Göre Sorgula</h1>
			<form method="post">
                 <label for="userid">
					<i class="fa fa-bars"></i>
				</label>
				<input type="text" name="derso" placeholder="Derse Göre" id="derso" required>
				<input type="submit" value="Sorgula" name="deer" />
			</form>
		</div>
		<div class="login">
			<h1>Proje Adına Göre Sorgula</h1>
			<form method="post">
                 <label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="projead" placeholder="Proje Adına Göre" id="projead" required>
				<input type="submit" value="Sorgula" name="proo">

			</form>
		</div>
		<div class="login">
			<h1>Döneme Göre</h1>
			<form method="post">
                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="text" name="donem" placeholder="Döneme Göre" id="donem" required>
				
				<input type="submit" value="Sorgula" name="doon">
			</form>
		</div>
		<div class="login">
			<h1>Yazara Göre</h1>
			<form method="post">
                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="text" name="yazar" placeholder="Yazara Göre" id="yazar" required>
				
				<input type="submit" value="Sorgula" name="yaaz">
			</form>
		</div>
		
		<?php


		echo "<br/><div class='sor'>
		<table border='1'>
<tr>
<th>Yükleyen</th>
<th>Yazar</th>
<th>Yazar No</th>
<th>Ders</th>
<th>Dönem</th>
<th>Öğrenim Türü</th>
<th>Başlık</th>

<th>Keywords</th>
<th>Danışman</th>
<th>Juri 1</th>
<th>Juri2</th>
</tr>
</div>";

$derss = $_POST['derso'];
$projj = $_POST['projead'];
$donemm = $_POST['donem'];
$yazarr = $_POST['yazar'];


if(isset($_POST['deer'])){
$result = mysqli_query($con,"SELECT * FROM dosyalar WHERE dosyaders ='$derss'");

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['dosyayukleyen'] . "</td>";
echo "<td>" . $row['dosyayazar'] . "</td>";
echo "<td>" . $row['dosyanumara'] . "</td>";
echo "<td>" . $row['dosyaders'] . "</td>";
echo "<td>" . $row['dosyadonem'] . "</td>";
echo "<td>" . $row['dosyatur'] . "</td>";
echo "<td>" . $row['dosyabaslik'] . "</td>";

echo "<td>" . $row['dosyakey'] . "</td>";
echo "<td>" . $row['dosyadanisman'] . "</td>";
echo "<td>" . $row['dosyajuri1'] . "</td>";
echo "<td>" . $row['dosyajuri2'] . "</td>";

echo "</tr>";
}
echo "</table>";
}





else if(isset($_POST['proo'])){
$result = mysqli_query($con,"SELECT * FROM dosyalar WHERE dosyabaslik = '$projj'");

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['dosyayukleyen'] . "</td>";
echo "<td>" . $row['dosyayazar'] . "</td>";
echo "<td>" . $row['dosyanumara'] . "</td>";
echo "<td>" . $row['dosyaders'] . "</td>";
echo "<td>" . $row['dosyadonem'] . "</td>";
echo "<td>" . $row['dosyatur'] . "</td>";
echo "<td>" . $row['dosyabaslik'] . "</td>";

echo "<td>" . $row['dosyakey'] . "</td>";
echo "<td>" . $row['dosyadanisman'] . "</td>";
echo "<td>" . $row['dosyajuri1'] . "</td>";
echo "<td>" . $row['dosyajuri2'] . "</td>";

echo "</tr>";
}
echo "</table>";
}





else if(isset($_POST['doon'])){
$result = mysqli_query($con,"SELECT * FROM dosyalar WHERE dosyadonem ='$donemm'");

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['dosyayukleyen'] . "</td>";
echo "<td>" . $row['dosyayazar'] . "</td>";
echo "<td>" . $row['dosyanumara'] . "</td>";
echo "<td>" . $row['dosyaders'] . "</td>";
echo "<td>" . $row['dosyadonem'] . "</td>";
echo "<td>" . $row['dosyatur'] . "</td>";
echo "<td>" . $row['dosyabaslik'] . "</td>";

echo "<td>" . $row['dosyakey'] . "</td>";
echo "<td>" . $row['dosyadanisman'] . "</td>";
echo "<td>" . $row['dosyajuri1'] . "</td>";
echo "<td>" . $row['dosyajuri2'] . "</td>";

echo "</tr>";
}
echo "</table>";
}



else if(isset($_POST['yaaz'])){
$result = mysqli_query($con,"SELECT * FROM dosyalar WHERE dosyayazar ='$yazarr'");

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['dosyayukleyen'] . "</td>";
echo "<td>" . $row['dosyayazar'] . "</td>";
echo "<td>" . $row['dosyanumara'] . "</td>";
echo "<td>" . $row['dosyaders'] . "</td>";
echo "<td>" . $row['dosyadonem'] . "</td>";
echo "<td>" . $row['dosyatur'] . "</td>";
echo "<td>" . $row['dosyabaslik'] . "</td>";

echo "<td>" . $row['dosyakey'] . "</td>";
echo "<td>" . $row['dosyadanisman'] . "</td>";
echo "<td>" . $row['dosyajuri1'] . "</td>";
echo "<td>" . $row['dosyajuri2'] . "</td>";

echo "</tr>";
}
echo "</table>";
}


?>
	</body>
</html>