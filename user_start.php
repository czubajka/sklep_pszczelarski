<?php 
	session_start();
	require "funkcje_sklep.php";
	if (!isset($_SESSION['zalogowany'])) //jeśli nieprawda, że zalogowany
	{
		header('Location: login.php');
		exit();
	}
	if (isset($_SESSION['admin']) && ($_SESSION['admin'] == true)) //jeśli zalogowany admin
	{
		header('Location: admin.php');
		exit();
	}
?>	
	<!DOCTYPE HTML>
<html lang="pl-PL">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Karolina Nędza-Sikoniowska">
    <title>Pasieka Miodek Uli</title>
    <meta name="description" content="Mała, przydomowa pasieka rodzinna u podnóża Tatr. Internetowy sklep     pszczelarski.">
    <meta name="keywords" content="miód, pasieka, sklep internetowy, Tatry">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon-bee.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
	<link rel="stylesheet" href="styl1.css" type="text/css">
    <meta http-equiv="creation-date" content="Mon, 06 May 2017 21:29:02 GMT">
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div id="top"><nav>
	<div class="nav"><a href="index.php">o nas</a></div>
    <div class="nav"><a href="news.php">co nowego?</a></div>
    <div class="nav"><a href="sklep.php">sklep</a></div>
	<div class="nav"><a href="kontakt.php">kontakt</a></div>
    <?php
	if (isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true)
	{
		echo '<div class="nav"><a href="user_start.php">twoje konto</a></div>';
	}
	else
	{
		echo '<div class="nav"><a href="register.php">rejestracja</a></div>';
	}
	?>
	<?php
	if (isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true)
	{
		echo '<div class="nav"><a href="logout.php"><span style="color:crimson;">wyloguj</span></a></div>';
	}
	else
	{
		echo '<div class="nav"><a href="login.php"><span style="color:crimson;">zaloguj</span></a></div>';
	}
	?>
	<div style="clear:both"></div>
</nav></div>
 
 <div id="logo">
	<h1>Pasieka MIODEK ULI</h1>
	<h2>panel użytkownika</h2>
 </div>
 
 <div id="main">
	<div id="maincontent">
<?php 
		echo "<h3>Witaj ".$_SESSION['imie']."!</h3>";
		echo '<div id="logout">[<a href="logout.php">WYLOGUJ MNIE</a>]</div>';
		echo "<p><strong>Twój login: </strong>".$_SESSION['login']."</p>";
		echo "<p><strong>Imię: </strong>".$_SESSION['imie']."</p>";
		echo "<p><strong>Nazwisko: </strong>".$_SESSION['nazwisko']."</p>";
		echo "<p><strong>E-mail: </strong>".$_SESSION['email']."</p>";
		echo "<p><strong>Wykształcenie: </strong>".$_SESSION['edu']."</p>";
		echo "<p><strong>Wyraziłeś chęć otrzymywania newslettera?  </strong>";
			if($_SESSION['zgoda_news']==0)
				echo "Nie!</p>";
			else if ($_SESSION['zgoda_news']==1)
				echo 'Tak :)'."</p>";
			else echo "wystąpił jakiś błąd</p>";
		echo "<p><strong>Adres: </strong></p>";
		echo "<p>ulica ".$_SESSION['ulica']." nr ".$_SESSION['nrdomu']."<br>".
				$_SESSION['kodpocztowy'].", ".$_SESSION['miejscowosc']."</p>";
		
		echo "<h3>Twoje zamówienia:</h3>";
		$zamowienia = zamowienia($_SESSION['login']);
		
		foreach($zamowienia as $row)
		{
			echo "<div class=\"zamowienie\">";
			echo "<div class =\"zam\"><strong>Zamówienie nr </strong>".$row['id_zamowienie']."</div>";
			echo "<div class =\"zam\"><strong>Data zamówienia:</strong> ".$row['data_zamowienia']."</div>";
			echo "<div class =\"zam\"><strong>Status:</strong> ".$row['nazwa']."</div>";
			echo "<div style=\"clear: both\"></div>";
			echo "</div>";
			$szczegolyzamowienia = szczegolyzamowienia($row['id_zamowienie']);
			foreach($szczegolyzamowienia as $rekord)
			{
				echo "<div class=\"szczegoly\">";
				echo "<div class =\"s\"><strong>Miód </strong>".$rekord['nazwa_m']."</div>";
				echo "<div class =\"s\"> ".$rekord['nazwa_poj']."</div>";
				echo "<div class =\"s\"><strong>Ilość:</strong> ".$rekord['ilosc']."</div>";
				echo "<div class =\"s\"><strong>Cena :</strong> ".$rekord['cenajednostkowa']."</div>";
				echo "<div style=\"clear: both\"></div>";
				echo "</div>";
			}
			
		}
?>
</div>
	<div style="clear: both"></div>
</div>
<footer>
	 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
</footer>
</body>
</html>
</body>
</html>