<?php
	session_start();
	require_once "funkcje_sklep.php";
	
	if(!isset($_SESSION['walidacja']) || !isset($_SESSION['d_adres_ulica']))
	{
		header('Location: login.php');
		exit();
	}
	else
	{
		unset($_SESSION['walidacja']);
		//Usuwanie zmiennych sesyjnych pamiętających wartości wpisywane do pól rejestracji oraz błędów
		if(isset($_SESSION['form_name'])) unset($_SESSION['form_name']);
		if(isset($_SESSION['form_sname'])) unset($_SESSION['form_sname']);
		if(isset($_SESSION['form_address_city'])) unset($_SESSION['form_address_city']);
		if(isset($_SESSION['form_address_nr'])) unset($_SESSION['form_address_nr']);
		if(isset($_SESSION['form_address_post'])) unset($_SESSION['form_address_post']);
		if(isset($_SESSION['form_address_str'])) unset($_SESSION['form_address_str']);
		if(isset($_SESSION['error_login'])) unset($_SESSION['error_login']);
		if(isset($_SESSION['error_pswd'])) unset($_SESSION['error_pswd']);
		if(isset($_SESSION['error_adres'])) unset($_SESSION['error_adres']);
		
		if ($_SESSION['d_adres_ulica']==$_SESSION['ulica'] 
			&& $_SESSION['d_kodp']==$_SESSION['kodpocztowy'] 
			&& $_SESSION['d_ulica_nr']==$_SESSION['nrdomu']
			&& $_SESSION['d_miejsce']==$_SESSION['miejscowosc'])		//jeśli adres wysyłki == adres użytkownika w bazie
		{
			$adres = $_SESSION['adres'];
		}
		else		//jeśli inny adres, dodaję go do bazy
		{

			mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				
				try
				{
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					$connection->set_charset("utf8");			
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
							
							$query = "INSERT INTO adres VALUES (NULL, '".$_SESSION['d_adres_ulica']."', '".$_SESSION['d_ulica_nr']."', '".$_SESSION['d_miejsce']."', '".$_SESSION['d_kodp']."')";
							if($connection->query($query))
							{
								$adres = mysqli_insert_id($connection);
							}
							else
							{
								throw new Exception($connection->error);
							}
						$connection->close();
					}
				}
				catch(Exception $err)
				{
					echo '<span class="error" style="font-weight: bold; font-size: 3em;">Błąd w pasiece! Coś się wyroiło! Wróć do nas później!</span>';
					//echo '<br>Informacja developerska: '.$err;
				}
		}
		//usuwam zmienne przechowujące adres i zmienną walidacyjną
		unset($_SESSION['d_miejsce']);
		unset($_SESSION['d_kodp']);
		unset($_SESSION['d_ulica_nr']);
		unset($_SESSION['d_adres_ulica']);
		unset($_SESSION['walidacja']);
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
	<h2>Dziękujemy za złożenie zamówienia!</h2>
 </div>
	<div id="main">
		<div id="maincontent">
		<?php
		$query = "INSERT INTO zamowienie VALUES(NULL, '".$_SESSION['login']."', NULL, '1', NULL, '".$adres."', '".$_SESSION['dostawa']."')";
		//kod wkładający zamówienie
		
		
		mysqli_report(MYSQLI_REPORT_STRICT); //raportowanie o błędach w wyjątkach
				try
				{
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
					$connection->set_charset("utf8");			
					if($connection->connect_errno!=0)
					{
						throw new Exception(mysqli_connect_errno());
					}
					else
					{
							if($connection->query($query))
							{
								$nr_zamowienia = mysqli_insert_id($connection);
								//wstawiam sumaryczne dane zamowienia
										foreach($_SESSION['koszyk'] as $id_mp=>$ilosc)
										{
											$miod= pobierz_szczegoly_miodu($id_mp);

											//wstawiam pojedyncze rekordy zamowienia
											$query = "INSERT INTO tresc_zamowienia VALUES(NULL, '".$miod['id_mp']."', '".$ilosc."', '".$nr_zamowienia."', '".$miod['cena']."')";
											if(!($connection->query($query)))
											{
												throw new Exception($connection->error);
											}
										}
										
							}
							else
							{
								throw new Exception($connection->error);
							}
						wyczysc_koszyk();
						echo "Status swojego zamówienia będziesz mógł sprawdzić w swoim panelu użytkownika";
						$connection->close();
					}
				}
				catch(Exception $err)
				{
					echo '<span class="error" style="font-weight: bold; font-size: 3em;">Błąd w pasiece! Coś się wyroiło! Wróć do nas później!</span>';
					//echo '<br>Informacja developerska: '.$err;
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
		