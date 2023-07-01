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
				<h1>File Check <br/>Admin Menu<br/>Kullanıcı Ekle</h1>
				<td>Mevcut Kullanıcı:</td>
						<td><?=$_SESSION['name']?></td>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
				<br/>
				<a href="Sorgu.php"><i class="fab fa-500px"></i>Sorgu 1</a>
				<a href="Sorgulama.php"><i class="fas fa-archive"></i>Sorgu 2</a>
				
			</div>
		</nav>
		<div class="login">
			<h1>Ekle</h1>
			<form action="Add.php" method="post">
                 <label for="userid">
					<i class="fa fa-bars"></i>
				</label>
				<input type="text" name="userid" placeholder="Kullanıcı ID" id="userid" required>
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Kullanıcı Adı" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="text" name="password" placeholder="Şifre" id="password" required>
				<label for="usertype">
					<i class="fa fa-adjust"></i>
				</label>
				<input type="text" name="usertype" placeholder="Kullanıcı Tipi" id="usertype" required>
				<input type="submit" value="Yeni Kullanıcıyı Ekle">
			</form>
		</div>
		<div class="login">
			<h1>Güncelle</h1>
			<form action="Updating.php" method="post">
                 <label for="userid">
					<i class="fa fa-bars"></i>
				</label>
				<input type="text" name="useridup" placeholder="Kullanıcı ID" id="useridup" required>
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="usernameup" placeholder="Kullanıcı Adı" id="usernameup" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="text" name="passwordup" placeholder="Şifre" id="passwordup" required>
				<label for="usertype">
					<i class="fa fa-adjust"></i>
				</label>
				<input type="text" name="usertypeup" placeholder="Kullanıcı Tipi" id="usertypeup" required>
				<input type="submit" value="Kullanıcıyı Güncelle">
			</form>
		</div>
		<div class="login">
			<h1>Sil</h1>
			<form action="Deleting.php" method="post">
                 <label for="userid">
					<i class="fa fa-bars"></i>
				</label>
				<input type="text" name="useriddel" placeholder="Kullanıcı ID" id="useriddel" required>
				
				<input type="submit" value="Kullanıcıyı Sil">
			</form>
			</div>
		
		
		<?php
		echo "<div class='login'>
		<table border='1'>
<tr>
<th>ID</th>
<th>Kullanıcı Adı</th>
<th>Şifre</th>
<th>Kullanıcı Tipi</th>
</tr>
</div>";

$result = mysqli_query($con,"SELECT * FROM users");


while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['iduser'] . "</td>";
echo "<td>" . $row['nameuser'] . "</td>";
echo "<td>" . $row['passuser'] . "</td>";
echo "<td>" . $row['typeuser'] . "</td>";
echo "</tr>";
}
echo "</table>";

?>
	</body>
</html>