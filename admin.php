<?php 
	session_start();
	require "funkcje_sklep.php";
		if (!isset($_SESSION['admin']) || (!$_SESSION['admin'] == true)) //jeśli nieprawda, że zalogowany admin
	{
		header('Location: login.php');
		exit();
	}
	
	if(!isset($_SESSION['opis_admin'])) {$_SESSION['opis_admin'] = " Witaj admin!";}
	
	
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
	<h2>panel administratora</h2>
 </div>
 
 <div id="main">
	<div id="maincontent">
	<br><br>
	<p style="color:red; font-size: large">
	<?php 
	echo $_SESSION['opis_admin'];
	$_SESSION['opis_admin'] = " ";	
	?>
	</p>
	<h3>Dodaj nowy miód</h3>
	<form action="dodaj.php" method="post">
  <table border="0">
  <tr>
    <td>Nazwa Miodu:</td>
    <td><input type="text" name="nazwamiodu" size="40" maxlength="40"/></td>
  <tr/>
  <tr>  
	<td>Opis Miodu</td>
	<td><input type="text" name="opismiodu" size="100" maxlength="400"/></td>
   </tr>
  <tr>
    <td>
    <input type="submit" name="dodaj_m" value="Dodaj"/></form>
    </td>
  </tr>
  </table>
  <br><br>
 	<h3>Usuń miód z bazy</h3>
	<p>Usunięcie głównej kategorii miodu</p>
	<form method="post" action="dodaj.php">
  <table border="0">
  <tr>
    <td>ID Miodu:</td>
    <td><input type="text" name="idmiodu" size="40" maxlength="40"/></td>
  <tr/>
    <td>  
    <input type="submit" name="usunm" value="Usuń"/></form>
    </td>
  </tr>
  </table>

	<br><br>
  	<h3>Dodaj nowy słoik</h3>
	<p>Dodanie konkretnej pojemności miodu do już dodanego rodzaju miodu.</p>
	<form method="post" action="dodaj.php">
  <table border="0">
  <tr>
    <td>ID miodu (rodzaj):</td>
    <td><input type="text" name="id_miod" size="40" maxlength="40"/></td>
  <tr/>
  <tr>  
	<td>pojemność</td>
	<td>
			<input type="radio" name="id_poj" value="1" checked> 0,25L<br>
			<input type="radio" name="id_poj" value="2"> 0,5L<br>
			<input type="radio" name="id_poj" value="3"> 1L<br>
			<input type="radio" name="id_poj" value="4"> 2L<br>
	</td>
   </tr>
   <tr>  
	<td>Ilość</td>
	<td><input type="text" name="ilosc" size="40" maxlength="40"/></td>
   </tr>
   <tr>  
	<td>Cena</td>
	<p>format [0.00]</p>
	<td><input type="text" name="cena" size="40" maxlength="40"/></td>
   </tr>
  <tr>
    <td>  
    <input type="submit" name="dodaj_mp" value="Dodaj"/></form>
    </td>
  </tr>
  </table>
  
  <br><br>
 	<h3>Usuń miód z bazy</h3>
	<p>Usunięcie słoika miodu</p>
	<form method="post" action="dodaj.php">
  <table border="0">
  <tr>
    <td>ID Miodu/Pojemności:</td>
    <td><input type="text" name="sloik" size="40" maxlength="40"/></td>
  <tr/>
    <td>  
    <input type="submit" name="usunsloik" value="Usuń"/></form>
    </td>
  </tr>
  </table>
   
<br><br>
 	<h3>Zaktualizuj status zamówienia</h3>
	<form method="post" action="dodaj.php">
  <table border="0">
  <tr>
    <td>Numer zamówienia:</td>
    <td><input type="text" name="id_zamowienie" size="10" maxlength="20"/></td>
  <tr/>
  <tr>  
	<td>podaj aktualny status</td>
	<td>
			<input type="radio" name="status" value="1" checked> złożone<br>
			<input type="radio" name="status" value="2"> w trakcie realizacji<br>
			<input type="radio" name="status" value="3"> wysłane/odebrane<br>
			<input type="radio" name="status" value="4"> anulowane<br>
	</td>
   </tr>
  <tr>
    <td>  
    <input type="submit" name="order" value="Aktualizuj"/></form>
    </td>
  </tr>
  </table>
<?php 
	
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