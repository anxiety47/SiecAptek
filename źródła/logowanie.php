<?php
session_start();

function __autoload($class_name) {
	include $class_name . '.php';
}


$uzytkownik = new Apteka;
$wynik = $uzytkownik->zaloguj();

if ($wynik == -1)
	echo "<p>Brak połączenia z bazą. <a href='start.php'>Zaloguj ponownie</a></p>";
else if ($wynik == -2)
        echo "<p>Dane nie zostały wprowadzone. <a href='start.php'>Zaloguj ponownie</a></p>";
else if($wynik == -3) {
	echo "<p>Logowanie zakończone sukcesem. Kliknij <a href='Baza.php'>tutaj</a>, aby przejść do bazy danych.</p>";
	echo "<p>Jeśli chcesz się wylogować, kliknij <a href='wylogowanie.php'>tutaj</a>.</p>";
}
else if($wynik == -4)
{
	echo "<p>Zalogowałeś się na konto administratora. Kliknij <a href='BazaAdmin.php'>tutaj</a>, aby przejść do bazy danych.</p>";
}
else
	echo "<p>Źle wypełniony formularz. <a href='start.php'>Zaloguj ponownie</a></p>";


?>
