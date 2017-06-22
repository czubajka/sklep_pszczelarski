<?php
	session_start();
	
	if (isset($_SESSION['zalogowany'])&&$_SESSION['zalogowany']==true)
	{
		header('Location: user_start.php');
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<title>Logowanie</title>
	<link rel="stylesheet" href="styl.css">
	<link rel="icon" href="img/favicon-bee.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
    <meta http-equiv="creation-date" content="Mon, 06 May 2017 21:29:02 GMT">
</head>
<body>
	<h2>Zaloguj się na swoje konto!</h2>
	<form action="log_in.php" method="post">
		<fieldset>
			<p>Login <input type="text" name="login"/></p>
			<p>Hasło <input type="password" name="pswd"/></p>
			<p><input type="submit" value="Zaloguj"/></p>
		</fieldset>
	</form>
	
<?php
	if(isset($_SESSION['blad_logowania'])) 
		echo $_SESSION['blad_logowania'];
?>
	
	<p><small>Nie mam jeszcze konta, ale chciałbym/chciałabym je założyć.</small></p>
	<p><a href="register.php">kliknij tutaj aby się zarejestrować</a></p>
</body>
</html>