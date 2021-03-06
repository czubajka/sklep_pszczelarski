<?php
session_start();
require "funkcje_sklep.php";


$id_miod = $_GET['id_miod'];
if(isset($_GET['id_miod'])) unset($_GET['id_miod']);

$_SESSION['url'] = "show_me_my_miod.php?id_miod=".$id_miod;
$miod = pobierz_nazwe_miodu($id_miod);

// oosługa koszyka
if(!isset($_SESSION['suma'])) 
{
	$_SESSION['suma']=0.0;
}

if(!isset($_SESSION['produkty_ilosc']))
{
	$_SESSION['produkty_ilosc']=0;
}

if(!isset($_SESSION['koszyk']))
{
	$_SESSION['koszyk'] = array();
}

if(isset($_POST['zapisz']))
{
	foreach($_SESSION['koszyk'] as $id_mp => $ilosc)
	{
		if($_POST[$id_mp]=='0')
		{
			unset($_SESSION['koszyk'][$id_mp]);
		}
		else
		{
			$_SESSION['koszyk'][$id_mp]=$_POST[$id_mp];
		}
	}
	$_SESSION['suma'] = policz_sume($_SESSION['koszyk']);
	$_SESSION['produkty_ilosc'] = policz_produkty($_SESSION['koszyk']);
	
}
?>



<!DOCTYPE html>
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
    <meta http-equiv="creation-date" content="Mon, 17 June 2017 21:29:02 GMT">
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
	<h2>sklep internetowy</h2>
 </div>
 
 <div id="main">
	<div id="maincontent">
	<h3><?php echo "Miód ".$miod; ?></h3>
<?php	//pobieranie miodów z bazy
$tablica_miodow = pobierz_miody($miod);
//wyświetlanie linków do miodów
wyswietl_miody_pojemnosci($tablica_miodow);

?>
<a href="sklep.php"><h3>[POWRÓT NA STRONĘ GŁÓWNĄ KATEGORII]</h3></a>
</div>
	<aside id="basket">
		<div>
		<h3>Twój koszyk:</h3>
<?php 
if(($_SESSION['koszyk']) && (array_count_values($_SESSION['koszyk'])))
{
	pokaz_koszyk($_SESSION['koszyk']);
}
else
{
	echo "<p>Koszyk jest pusty</p>";
}
$akcja = "sklep.php";

przycisk("do_kasy.php", "Idz do kasy");

?>
		
		</div>
	</aside>
	<div style="clear: both;"></div>
 </div>
 
 <footer>
	 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
 </footer>
 
 </body>
 </html>
