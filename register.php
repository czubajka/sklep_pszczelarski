<?php
	session_start();
	
	//przetwarzanie formularza
	if (isset($_POST['email']))		//sprawdzam, czy formularz był już wysłany
	{
		$walidacja = true;			//zmienna walidacyjna
		$login = $_POST['login'];
		$pswd = $_POST['pswd'];
		$pswd2 = $_POST['pswd2'];
		$name = $_POST['imie'];
		$sname = $_POST['nazwisko'];
		$email = $_POST['email'];
		$address_str = $_POST['adres_ulica'];
		$address_nr = $_POST['ulica_nr'];
		$address_post = $_POST['kodp'];
		$address_city = $_POST['miejsce'];
		$add_to_nl = $_POST['newsletter'];
		$edu = $_POST['edu'];
		
		//poprawność loginu
		if(strlen($login)<3 || strlen($login)>20)
		{
			$walidacja = false;
			$_SESSION['error_login'] = "Login powinien mieć długość od 3 do 20 znaków.";
		}
		if(ctype_alnum($login)==false)
		{
			$walidacja = false;
			$_SESSION['error_login'] = "Login może składać się tylko z cyfr i liter bez polskich znaków.";
		}
		
		//poprawność e-mail
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false)||($emailB!=$email))
		{
			$walidacja = false;
			$_SESSION['error_email'] = "Podaj poprawny adres e-mail.";
		}
		
		//poprawność hasła
		if(strlen($pswd)<8 || strlen($pswd)>20)
		{
			$walidacja = false;
			$_SESSION['error_pswd'] = "Hasło powinno zawierać od 8 do 20 znaków.";
		}
		if($pswd!=$pswd2)
		{
			$walidacja = false;
			$_SESSION['error_pswd'] = "Podane hasła są różne.";
		}
		// hashowanie hasła
		$pswd_hash = password_hash($pswd, PASSWORD_DEFAULT);
		
		// sprawdzanie akceptacji regulaminu
		if(!isset($_POST['regulamin']))
		{
			$walidacja = false;
			$_SESSION['error_regulamin'] = "Musisz zaakceptować regulamin.";
		}
		
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
		
		//Bot or not? Oto jest pytanie!
		$secretkey = "6LeVLCUUAAAAABKZWcWyB9YdEc_v0hYYLoWwAfbK";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretkey.'&response='.$_POST['g-recaptcha-response']);
		$odpowiedz = json_decode($check);
		if($odpowiedz->success==false)
		{
			$walidacja = false;
			$_SESSION['error_recaptcha'] = "Potwierdź, że jesteś człowiekiem.";
		}	
		
		//zapamiętywanie wprowadzanych danych przy nieudanej walidacji
		$_SESSION['form_login']=$login;
		$_SESSION['form_email']=$email;
		$_SESSION['form_name']=$name;
		$_SESSION['form_sname']=$sname;
		$_SESSION['form_address_str']=$address_str;
		$_SESSION['form_address_nr']=$address_nr;
		$_SESSION['form_address_post']=$address_post;
		$_SESSION['form_address_city']=$address_city;
		$_SESSION['form_add_to_nl']=$add_to_nl;
		$_SESSION['form_edu']=$edu;
		
		
		require_once "mysql.php";
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
				//czy email juz istnieje
				$result = $connection->query("SELECT login FROM user WHERE email='$email'");
				if(!$result) throw new Exception($connecton->error);	//jeśli nie udało się zapytanie
				
				$num_of_emails = $result->num_rows;
				if($num_of_emails>0)
				{
					$walidacja = false;
					$_SESSION['error_email'] = "Istnieje już konto przypisane do podanego adresu e-mail.";	
				}
				
				//czy login juz istnieje
				$result = $connection->query("SELECT login FROM user WHERE login='$login'");
				if(!$result) throw new Exception($connecton->error);	//jeśli nie udało się zapytanie
				
				$num_of_logins = $result->num_rows;
				if($num_of_logins>0)
				{
					$walidacja = false;
					$_SESSION['error_login'] = "Login zajęty.";	
				}
				if($walidacja == true)		//formularz wykonany poprawnie, dodajemy użytkownika do bazy
				{
					if($connection->query("INSERT INTO user VALUES ('$login', '$name', '$sname', '$pswd_hash', '$email', $edu, $add_to_nl, NULL)") 
					&& ($connection->query("INSERT INTO adres VALUES (NULL, '$address_str', '$address_nr', '$address_city', '$address_post')")) 
					&& ($connection->query("UPDATE user, adres SET user.adres = adres.id_adres WHERE user.login = '$login' AND adres.miejscowosc = '$address_city' AND adres.ulica = '$address_str' AND adres.nrdomu = '$address_nr' AND adres.kodpocztowy = '$address_post'")) 
					&& ($connection->query("UPDATE user, edu SET user.wyksztalcenie = edu.id_edu WHERE edu.id_edu = '$edu' AND user.login = '$login'")))
					{
						
						$_SESSION['udanarejestracja'] = true;
						foreach($_POST['hobby'] as $var)
						{
							$result = $connection->query("INSERT INTO user_hobby VALUES (NULL, '$login', '$var')");
							if(!$result) throw new Exception($connecton->error);	//jeśli nie udało się zapytanie
						};
						$_SESSION['user'] = $login;	//zapamiętanie użytkownika
						header('Location: new_start.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
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
	<h2>rejestracja</h2>
 </div>
 
 <div id="main">
	<div id="maincontent">
	<p>Zapraszamy do rejestracji w naszym portalu.</p>
	<form method="post">
		<fieldset>
			<legend>Dane logowania</legend>
			<p><label>Login<br/><input type="text" name="login"
			<?php 
				if(isset($_SESSION['form_login']))
				{
					echo 'value= "'.$_SESSION['form_login'].'"';
					unset($_SESSION['form_login']);
				}
			?>
			/></label>
			<?php
				if(isset($_SESSION['error_login']))
				{
						echo '<div class="error">'.$_SESSION['error_login'].'</div>';
						unset($_SESSION['error_login']);
				}
			?></p>
			<p><label>Hasło <br/><input type="password" name="pswd"/></label>
			<?php
				if(isset($_SESSION['error_pswd']))
				{
						echo '<div class="error">'.$_SESSION['error_pswd'].'</div>';
						unset($_SESSION['error_pswd']);
				}
			?></p>
			<p><label>Powtórz hasło <br/><input type="password" name="pswd2"/></label></p>
			<p><label>Akceptuję regulamin<input type="checkbox" name="regulamin"/> </label>
			<?php
				if(isset($_SESSION['error_regulamin']))
				{
						echo '<div class="error">'.$_SESSION['error_regulamin'].'</div>';
						unset($_SESSION['error_regulamin']);
				}
			?></p>
		</fieldset>
		<fieldset>
		  <legend>Podstawowe dane</legend>
			<p><label>Imię <br/><input type="text" name="imie" 
			<?php 
				if(isset($_SESSION['form_name']))
				{
					echo 'value= "'.$_SESSION['form_name'].'"';
					unset($_SESSION['form_name']);
				}
			?>
			/></label></p>
			<p><label>Nazwisko <br/><input type="text" name="nazwisko"
			<?php 
				if(isset($_SESSION['form_sname']))
				{
					echo 'value= "'.$_SESSION['form_sname'].'"';
					unset($_SESSION['form_sname']);
				}
			?>
			/></label></p>
			<p><label>Adres e-mail <br/><input type="e-mail" name="email" placeholder="twój@email" 
			<?php 
				if(isset($_SESSION['form_email']))
				{
					echo 'value= "'.$_SESSION['form_email'].'"';
					unset($_SESSION['form_email']);
				}
			?>
			/></label>
			<?php
				if(isset($_SESSION['error_email']))
				{
					echo '<div class="error">'.$_SESSION['error_email'].'</div>';
					unset($_SESSION['error_email']);
				}
			?></p>
			<p><label>Adres:<br/> ul. <input type="text" name="adres_ulica" placeholder="ulica" 
			<?php 
				if(isset($_SESSION['form_address_str']))
				{
					echo 'value= "'.$_SESSION['form_address_str'].'"';
					unset($_SESSION['form_address_str']);
				}
			?>
			/></label>
				<label>nr <input type="text" name="ulica_nr" placeholder="111/1" 
			<?php 
				if(isset($_SESSION['form_address_nr']))
				{
					echo 'value= "'.$_SESSION['form_address_nr'].'"';
					unset($_SESSION['form_address_nr']);
				}
			?>
			/></label>
				<label> kod <input type="text" name="kodp" placeholder="00-000" 
			<?php 
				if(isset($_SESSION['form_address_post']))
				{
					echo 'value= "'.$_SESSION['form_address_post'].'"';
					unset($_SESSION['form_address_post']);
				}
			?>
			/></label>
				<label>, <input type="text" name="miejsce" placeholder="miejscowość" 
			<?php 
				if(isset($_SESSION['form_address_city']))
				{
					echo 'value= "'.$_SESSION['form_address_city'].'"';
					unset($_SESSION['form_address_city']);
				}
			?>
			/></label>.<?php
				if(isset($_SESSION['error_adres']))
				{
						echo '<div class="error">'.$_SESSION['error_adres'].'</div>';
						unset($_SESSION['error_adres']);
				}
			?></p>
			<p><label>Wykształcenie <br/><select name="edu" size="1" >
			<optgroup label="Podstawowe">
			  <option value="1" <?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 1)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>brak</option>
			  <option value="2" <?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 2)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>podstawowe</option>
			</optgroup>
			<optgroup label="Średnie">
			  <option value="5" <?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 5)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>średnie ogólnokształcące</option>
			  <option value="4"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 4)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>średnie zawodowe</option>
			  <option value="3"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 3)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>średnie techniczne</option>
			</optgroup>
			<optgroup label="Wyższe">
			  <option value="6"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 6)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>wyższe licencjackie</option>
			  <option value="7"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 7)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>wyższe inżynierskie</option>
			  <option value="8"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 8)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>wyższe magisterskie</option>
			  <option value="9"<?php 
				if(isset($_SESSION['form_edu']) && $_SESSION['form_edu'] == 9)
				{
					echo 'selected';
					unset($_SESSION['form_edu']);
				}
			  ?>>wyższe doktoranckie</option>
			</optgroup></select></label></p>
		</fieldset>
		<fieldset>
		  <legend>Zapisz się do naszego newslettera!</legend>
			<p><label>Dodaj mnie!<input type="radio" name="newsletter" value="1" 
			<?php 
				if ((isset($_SESSION['form_add_to_nl']) && $_SESSION['form_add_to_nl']==1)||(!isset($_SESSION['form_add_to_nl'])))  //zaznacza 'dodaj mnie' gdy nie istnieje zmienna sesyjna zapamietujaca wartosc, lub gdy bylo juz zaznaczona na dodaj
				{
					echo 'checked = "checked"';
					unset($_SESSION['form_add_to_nl']);
				}
			?>></label></p>
			<p><label>Nie, dziękuję.<input type="radio" name="newsletter" value="0"
			<?php 
				if (isset($_SESSION['form_add_to_nl']) && $_SESSION['form_add_to_nl']==0)  //zaznacza 'nie dziekuje' gdy było tak wczesniej zaznaczone
				{
					echo 'checked = "checked"';
					unset($_SESSION['form_add_to_nl']);
				}
			?>></label></p>		
		</fieldset>
		<fieldset>
		  <legend>Zainteresowania</legend>
		  <p><label><input type="checkbox" name="hobby[]" value="1" checked="checked">pszczelarstwo ;)</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="2">turystyka</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="5">gastronomia</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="4">fauna</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="3">flora</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="6">rolnictwo</label></p>
		  <p><label><input type="checkbox" name="hobby[]" value="7">nic w tej tematyce</label></p>
		</fieldset>
		<div class="g-recaptcha" data-sitekey="6LeVLCUUAAAAANhiJqfeH4BdhrTpEnEHc4zPZT4K"></div>
		<?php
				if(isset($_SESSION['error_recaptcha']))
				{
						echo '<div class="error">'.$_SESSION['error_recaptcha'].'</div>';
						unset($_SESSION['error_recaptcha']);
				}
			?>
		<p><input type="reset" value="Wyczyść pola">
		<input type="submit" value="Wyślij!"></p>
	</form>
	</div>
	<div style="clear: both"></div>
</div>
<footer>
	 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
</footer>
</body>
</html>
