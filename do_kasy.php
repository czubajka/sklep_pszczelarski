<?php
session_start();
require "funkcje_sklep.php";

if (isset($_POST['adres_ulica']))		//sprawdzam, czy formularz adresu był już wysłany
	{
		$walidacja = true;			//zmienna walidacyjna
		$name = $_POST['imie'];
		$sname = $_POST['nazwisko'];
		$address_str = $_POST['adres_ulica'];
		$address_nr = $_POST['ulica_nr'];
		$address_post = $_POST['kodp'];
		$address_city = $_POST['miejsce'];
		// sprawdzanie adresu
		if(strlen($address_str)<3 || strlen($address_str)>30)
		{
			$walidacja = false;
			$_SESSION['error_adres'] = "Nazwa ulicy powina mieć długość od 3 do 30 znaków.";
		}
		else
		{
			$address_str = htmlentities($address_str, ENT_QUOTES, 'UTF-8');		//czyszczenie danych
		}
		
		$address_city = htmlentities($address_city, ENT_QUOTES, 'UTF-8');		//czyszczenie danych
		if(strlen($address_city)<3 || strlen($address_city)>25)
		{
			$walidacja = false;
			$_SESSION['error_adres'] = "Nazwa miejscowości powina mieć długość od 3 do 25 znaków.";
		}
		
		$address_nr = htmlentities($address_nr, ENT_QUOTES, 'UTF-8');             //czyszczenie danych
		if(strlen($address_nr)>10)
		{
			$walidacja = false;
			$_SESSION['error_adres'] = "Numer dumu/mieszkania zbyt długi. Maksymalna długość to 10 znaków.";
		}
		
		$address_post = preg_replace('/[^0-9]/','',$address_post);             //usuwa znaki z kodu pocztowego
		if(strlen($address_post)!=5)
		{
			$walidacja = false;
			$_SESSION['error_adres'] = "Kod pocztowy powinien składać się z 5 cyfr.";
		}
		
		if($walidacja == false)
		{
			//zapamiętywanie wprowadzanych danych przy nieudanej walidacji
			$_SESSION['form_name']=$name;
			$_SESSION['form_sname']=$sname;
			$_SESSION['form_address_str']=$address_str;
			$_SESSION['form_address_nr']=$address_nr;
			$_SESSION['form_address_post']=$address_post;
			$_SESSION['form_address_city']=$address_city;	
		}
		else if($walidacja == true)		//formularz wykonany poprawnie, dane potrzebne do złożenia zamówienia kompletne
		{
			$_SESSION['walidacja']= true ;
			$_SESSION['dostawa'] = $_POST['dostawa'];
			$_SESSION['d_kodp'] = $_POST['kodp'];
			$_SESSION['d_adres_ulica'] = $_POST['adres_ulica'];
			$_SESSION['d_ulica_nr'] = $_POST['ulica_nr'];
			$_SESSION['d_miejsce'] = $_POST['miejsce'];
			header('Location: kasa.php');
			exit();
		}
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
	<style>
	table {
	font-size: 1em;
	}
	</style>
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
	
<?php
if(($_SESSION['koszyk']) && (array_count_values($_SESSION['koszyk'])))
{
	echo "<h3>Podsumowanie zamówienia:</h3>";
	pokaz_koszyk($_SESSION['koszyk'], false);
	echo "</br></br>";
	
	if (isset($_SESSION['zalogowany'])&& $_SESSION['zalogowany']==true)
	{
		
		
		echo "<h3>Dane do wysyłki:</h3>";
		echo "<p>Wypełnij formularz dostawy. Jeśli preferujesz wysyłkę na inny adres niż zaproponowany, wystarczy zmienić go w formularzu:</p>";
		echo "
		<form method=\"post\">
			<p><label><strong>Imię </strong><br/><input type=\"text\" name=\"imie\" value=\"".$_SESSION['imie']."\"";
			
				if(isset($_SESSION['form_name']))
				{
					echo 'value= "'.$_SESSION['form_name'].'"';
					unset($_SESSION['form_name']);
				}
			
		echo "/></label></p>
			<p><label><strong>Nazwisko </strong><br/><input type=\"text\" name=\"nazwisko\" value=\"".$_SESSION['nazwisko']."\"";
			
				if(isset($_SESSION['form_sname']))
				{
					echo 'value= "'.$_SESSION['form_sname'].'"';
					unset($_SESSION['form_sname']);
				}
			
		echo	"/></label></p>
			<p><label><strong>Adres:</strong><br/> ulica<br><input type=\"text\" name=\"adres_ulica\" placeholder=\"ulica\" value=\"".$_SESSION['ulica']."\""; 
			 
				if(isset($_SESSION['form_address_str']))
				{
					echo 'value= "'.$_SESSION['form_address_str'].'"';
					unset($_SESSION['form_address_str']);
				}
			
		echo	"/></label>
				<label><br>nr domu<br><input type=\"text\" name=\"ulica_nr\" placeholder=\"111/1\" value=\"".$_SESSION['nrdomu']."\""; 
			
				if(isset($_SESSION['form_address_nr']))
				{
					echo 'value= "'.$_SESSION['form_address_nr'].'"';
					unset($_SESSION['form_address_nr']);
				}
			
		echo	"/></label><br>
				<label> kod pocztowy<br><input type=\"text\" name=\"kodp\" placeholder=\"00-000\" value=\"".$_SESSION['kodpocztowy']."\""; 
			
				if(isset($_SESSION['form_address_post']))
				{
					echo 'value= "'.$_SESSION['form_address_post'].'"';
					unset($_SESSION['form_address_post']);
				}
			
		echo	"/></label>
				<label><br> miejscowość<br><input type=\"text\" name=\"miejsce\" placeholder=\"miejscowość\" value=\"".$_SESSION['miejscowosc']."\""; 
			
				if(isset($_SESSION['form_address_city']))
				{
					echo 'value= "'.$_SESSION['form_address_city'].'"';
					unset($_SESSION['form_address_city']);
				}
			
			echo "/></label>.";
			
				if(isset($_SESSION['error_adres']))
				{
						echo '<div class="error">'.$_SESSION['error_adres'].'</div>';
						unset($_SESSION['error_adres']);
				}

			$dostawa = pobierz_dostawe();		//pobieram dane dostępnych opcji dostawy
			echo "<p><strong>Wybierz sposób dostawy:</strong>";
			foreach($dostawa as $row)
			{
				echo "<br><input type=\"radio\" name=\"dostawa\" value=\"".$row['id_przesylka']."\"  checked=\"checked\"/>".$row['nazwa']." (".$row['cena']." PLN)";
			}
			echo "</p><br><br><input type=\"submit\" value=\"KUPUJĘ!\">";
	}
	else
	{
		echo "<h3>Nie jesteś zalogowany. Aby dokonać zamówienia zaloguj się na swoje konto lub zarejestruj.</h3>";
		echo <<<_END
		<form action="log_in.php" method="post">
				<fieldset>
					<p>Login <input type="text" name="login"/></p>
					<p>Hasło <input type="password" name="pswd"/></p>
					<p><input type="submit" value="Zaloguj"/></p>
					<input type="hidden" name="zkasy" value="true">
				</fieldset>
			</form>
_END;

	if(isset($_SESSION['blad_logowania'])) 
		echo $_SESSION['blad_logowania'];

	echo "<p><small>Jeśli nie masz jeszcze konta</small></p>
	<p><a href=\"register.php\">kliknij tutaj aby się zarejestrować</a></p>";
	}


}
else
{
	echo "<p>Koszyk pusty!</p>";
}
echo "<br><br>";
przycisk("sklep.php", "Kontynuuj zakupy");
przycisk("podsumowanie.php", "Rezygnacja");

?>
</div>
	<div style="clear: both"></div>
</div>
<footer>
	 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
</footer>
</body>
</html>