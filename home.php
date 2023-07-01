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
// In this case we can use the account ID to get the account info.



?>
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Ana Sayfa</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>File Check</h1>
				<h2>
				<td>Kullanıcı Adı:</td>
						<td><?=$_SESSION['name']?></td>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
				<a href="sorgupro.php"><i class="fas fa-asterisk"></i>Sorgu 1</a>
				<a href="Sorgulamapro.php"><i class="fas fa-archive"></i>Sorgu 2</a>
				
			</div>
		</nav>
		<div class="content">
			<h2>Ana Sayfa</h2>
			</div>
			<form enctype="multipart/form-data"   method="POST">
<center>
<br>
<h1>Ödevini Yüklemek İçin Dosya seçiniz:</h1>
<br>
<input type="file"name="file" >
<input type="submit" value="Yükle" name="readpdf">
</center>
<?php
		$yukleyen=$_SESSION['name'];

require('class.pdf2text.php');
extract($_POST);
if(isset($readpdf)){
      
    if($_FILES['file']['type']=="application/pdf") {
        $a = new PDF2Text();
        $a->setFilename($_FILES['file']['tmp_name']); 
        $a->decodePDF();
		$metin=$a->output();
		$kucuk=strtolower($metin);
		$ilk2 = stristr($kucuk,'20');
		$ilk = stristr($ilk2,'bolumu');
		$final = stristr($ilk,' ');
		
		$derst =  strpos($final,'projesi',0);
		$derst = $derst + 8;
		$ders = substr($final,0,$derst);
		
		$tarih1 =  strpos($final,'tarih: ',0);
		$tarih2 = $tarih1 + 10;
		$tarih = substr($final,$tarih2,2);
		$tarih = (int)$tarih;
		
		$tarih3 =  strpos($final,'tarih: ',0);
		$tarih4 = $tarih3 + 13;
		$tarihh = substr($final,$tarih4,4);
		$tarihh = (int)$tarihh;
		
		
		
		
		if($tarih>3 && $tarih<7){
			$tarihmevsim='bahar';
			$tarihh2 = $tarihh-1;
			$tarihh = (string)$tarihh;
			$tarihh2 = (string)$tarihh2;
			$tarihgenel=$tarihh2.'-'.$tarihh.' '.$tarihmevsim;
		}
		else if(3>$tarih){
			$tarihmevsim='güz';
			$tarihh2 = $tarihh-1;
			$tarihh = (string)$tarihh;
			$tarihh2 = (string)$tarihh2;
			$tarihgenel=$tarihh2.'-'.$tarihh.' '.$tarihmevsim;
		}
		else{
			$tarihmevsim='güz';
			$tarihh2 = $tarihh+1;
			$tarihh = (string)$tarihh;
			$tarihh2 = (string)$tarihh2;
			$tarihgenel=$tarihh2.'-'.$tarihh.' '.$tarihmevsim;
		}
		
		$ozett = strrpos($final,'abstract',0);
		$keywordst = strpos($final,'keywords',0);
		$keywordst-=11;
		$keywordstt = $keywordst-$ozett;
		$ozett+=8;
		$ozet = substr($final,$ozett,$keywordstt);
		
		$keywordsfinal = stristr($final,'keywords');
		$nokta = strpos($keywordsfinal,'.',0);
		$keywords = substr($keywordsfinal,10,$nokta);
		
		$final2 = stristr($final,'onsoz ve tesekkurler');
		$final3 = stristr($final2,'20');
		$isimt = strpos($final3,'bu dok',0);
		$isimt-=24;
		$isim = substr($final3,7,$isimt);
		
		$isimsinir = strpos($final,$isim,0);
		$isimsinir2=$isimsinir-$derst;
		$konu = substr($final,$derst,$isimsinir2);
		
		$not = strrpos($final,'ogrenci no:',0);
		$not+=12;
		$no = substr($final,$not,9);
		$ogrturs = str_split($no);
		if($ogrturs[5]=='1'){
			$ogrtur='birinci öğretim';
		}
		else if($ogrturs[5]=='2'){
			$ogrtur='ikinci öğretim';
		}
		
		$isimsinir +=strlen($isim);
		$danismans = strpos($final,'danisman',0);
		$danismant= $danismans-$isimsinir;
		$danisman = substr($final,$isimsinir,$danismant);
		
		$jurib = stristr($final,'univ.');
		//$juri1 = strrpos($final,'univ.',0);
		$juris = strpos($jurib,'juri uyesi',0);
		$juris-=13;
		$juri1 = substr($jurib,10,$juris);
		
		$juria = stristr($jurib,' univ.');
		$jurif = strpos($juria,'juri uyesi',0);
		$jurif-=13;
		$juri2 = substr($juria,10,$jurif);
		
		
		
		
			
		/*print($tarihgenel);
		echo "<br/>";
		print($konu);
		echo "<br/>";
		print($ders);
		echo "<br/>";
		print($ozet);
		echo "<br/>";
		print($keywords);
		echo "<br/>";
		print($isim);
		echo "<br/>";
		print($no);
		echo "<br/>";
		print($ogrtur);
		echo "<br/>";
		print($danisman);
		echo "<br/>";
		print($juri1);
		echo "<br/>";
		print($juri2);
		echo "<br/>";*/
		//print($file);
		trimm($tarihgenel);
		trimm($konu);
		trimm($ders);
		trimm($ozet);
		trimm($keywords);
		trimm($isim);
		trimm($no);
		trimm($ogrtur);
		trimm($danisman);
		trimm($juri1);
		trimm($juri2);
		
		
		$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '1234';
$DATABASE_NAME = 'filesystem';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, "$DATABASE_NAME");
		
		$user_check = "SELECT * FROM dosyalar WHERE dosyabaslik='$konu'LIMIT 1";
  $result = mysqli_query($con, $user_check);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['dosyabaslik'] === $konu) {
		print("Aynı Dosya Mevcut");
	}
  }
  else{
		$sql = "INSERT INTO dosyalar (dosyayukleyen, dosyayazar ,dosyanumara ,dosyaders, dosyadonem ,dosyatur ,dosyabaslik ,dosyaozet ,dosyakey ,dosyadanisman ,dosyajuri1 ,dosyajuri2)
VALUES ('$yukleyen' ,'$isim' ,'$no', '$ders' , '$tarihgenel' , '$ogrtur' , '$konu' , '$ozet' , '$keywords' , '$danisman' , '$juri1' , '$juri2')"; 

if (mysqli_query($con, $sql)) {
        echo "Yükleme Başarılı !";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($con);
     }
			
    }
	}
	
} 
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

$result = mysqli_query($con,"SELECT * FROM dosyalar WHERE dosyayukleyen ='$yukleyen'");

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
function trimm(&$value) 
{ 
    $value = trim($value); 
}
?>
</form>
	</body>
</html>