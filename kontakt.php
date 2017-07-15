<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl-PL">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Karolina Nędza-Sikoniowska">
    <title>Pasieka Miodek Uli - sklep internetowy i platforma pszczelarska</title>
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
	<div class="nav"><a href="kontakt.html">kontakt</a></div>
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
		 <!--formularz kontaktowy-->
    <form action="mailto:czubajka.kania@gmail.com?subject=Wiadomosc od internauty" method="post" enctype="text/plain">   
    <fieldset>
      <legend>Podstawowe dane</legend>
      <p><label for="imie" accesskey="i">Imię <input type="text" name="imie"></input></label></p>
    <p><label for="nazwisko" accesskey="n">Nazwisko <input type="text" name="nazwisko"></input></label></p>
    <p><label for="email" accesskey="e">Adres <input type="e-mail" name="email" placeholder="twój@email"></input></label></p>
    <p><label for="tel" accesskey="t">Telefon <input type="tel" name="tel" placeholder="komórkowy (opcjonalnie)"></input></label></p>
    <p><label for="skad" accesskey="s">Skąd o nas wiesz? <input type="text" name="skad" list="skadlista" placeholder="wybierz lub wpisz">
      <datalist id="skadlista">
        <option value="od znajomych">
        <option value="z internetu">
        <option value="z prasy">
        <option value="inne(wpisz)">
      </datalist></input></label></p>

      <p><label for="region" accesskey="r">Skąd jesteś? <select name="region" size="1">
        <optgroup label="Podhale">
          <option value="Zakopane">Zakopane</option>
          <option value="Kościelisko">Kościelisko</option>
          <option value="Poronin">Poronin</option>
          <option value="Witów">Witów</option>
          <option value="innepodhale">inna miejscowość podhalańska</option>
        </optgroup>
        <optgroup label="Polska">
          <option value="Małopolska">Małopolska</option>
          <option value="innapolska">inne województwo</option>
        </optgroup>
        <optgroup label="zagranica">
          <option value="Europa">Europa</option>
          <option value="innykontynent">poza Europą</option>
        </optgroup></select></label></p>
    </fieldset>
    <fieldset>
      <legend>Twoja wiadomość do nas</legend>
       <label for="wiadomosc" accesskey="w">
      <p><textarea name="wiadomosc" rows="4" cols="50" placeholder="Tutaj wpisz wiadomość"></textarea></p>              </label>
    </fieldset>
    <fieldset>
      <legend>Zapisz się do naszego newslettera!</legend>
        <p><label>Dodaj mnie!<input type="radio" name="newsletter" value="yes" checked="checked"></label></p>
        <p><label>Nie, dziękuję.<input type="radio" name="newsletter" value="no"></label></p> 
    </fieldset>
    <fieldset>
      <legend>Zainteresowania</legend>
      <p><label><input type="checkbox" name="hobby" value="pszczelarstwo" checked="checked">pszczelarstwo ;)            </label></p>
      <p><label><input type="checkbox" name="hobby" value="turystyka">turystyka</label></p>
      <p><label><input type="checkbox" name="hobby" value="gastronomia">gastronomia</label></p>
      <p><label><input type="checkbox" name="hobby" value="fauna">fauna</label></p>
      <p><label><input type="checkbox" name="hobby" value="flora">flora</label></p>
      <p><label><input type="checkbox" name="hobby" value="flora">turystyka</label></p>
      <p><label><input type="checkbox" name="hobby" value="nice">nic w tej tematyce</label></p>
    </fieldset>
    <p><input type="reset" value="Wyczyść pola">
    <input type="submit" value="Wyślij!"></p>
    </form>
	</div>
	<aside>
		<h3>Już niedługo miodobranie!</h3>
		<p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2602.388125523693!2d19.887179815805254!3d49.28799037831528!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4715ed3735c7394f%3A0x5b2cc4dd9b8726e3!2sN%C4%99dzy+Kubi%C5%84ca+205%2C+34-511+Ko%C5%9Bcielisko!5e0!3m2!1spl!2spl!4v1494113888247" width="100%" height="300" frameborder="1" style="border:1" allowfullscreen></iframe></p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel aliquam nunc, a mollis tortor. Duis ut bibendum urna. Vivamus iaculis velit lacus, a feugiat justo vehicula non. Aliquam vitae accumsan magna. Sed blandit porta urna vehicula faucibus. Phasellus id tristique libero. Fusce vestibulum id purus a egestas. Aliquam et augue ullamcorper, luctus quam id, bibendum eros. Praesent in lorem sit amet mauris sollicitudin congue. Maecenas ultricies risus eget mi maximus placerat. Donec dapibus quam sit amet facilisis aliquam. Nam bibendum diam quis dui commodo, nec efficitur nisi cursus. Nunc facilisis volutpat nibh in accumsan.</p>
	</aside>
	<div style="clear: both;"></div>
 </div>
 
 <footer>
	 <small>Wszystkie prawa zastrzeżone &copy;2017, <a href="mailto:karolcia999@gmail.com">Karolina Nędza-Sikoniowska</a></small>
 </footer>
 
 </body>
 </html>