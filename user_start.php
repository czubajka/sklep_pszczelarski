<?php 
	session_start();
	if (!isset($_SESSION['zalogowany'])) //jeśli nieprawda, że zalogowany
	{
		header('Location: login.php');
		exit();
	}
?>	
	<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Rejestracja użytkownika</title>
	<link rel="stylesheet" href="styl.css">
	<link rel="icon" href="img/favicon-bee.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
    <meta http-equiv="creation-date" content="Mon, 06 May 2017 21:29:02 GMT">
</head>
<body>
	<h2>Panel użytkownika</h2>
<?php 
		echo "<h3>Witaj ".$_SESSION['imie']."!</h3>";
		echo '<div id="logout">[<a href="logout.php">WYLOGUJ MNIE</a>]</div>';
		echo "<p><strong>Twój login: </strong>".$_SESSION['login']."</p>";
		echo "<p><strong>Imię: </strong>".$_SESSION['imie']."</p>";
		echo "<p><strong>Nazwisko: </strong>".$_SESSION['nazwisko']."</p>";
		echo "<p><strong>E-mail: </strong>".$_SESSION['email']."</p>";
		echo "<p><strong>Wyraziłeś chęć otrzymywania newslettera?  </strong>";
			if($_SESSION['zgoda_news']==0)
				echo "Nie!</p>";
			else if ($_SESSION['zgoda_news']==1)
				echo 'Tak :)'."</p>";
			else echo "wystąpił jakiś błąd</p>";

?>
</body>
</html>