<?php
session_start();
function __autoload($class_name) {
        include $class_name . '.php';
}

$uzytkownik = new Apteka;
$wynik = $uzytkownik->czy_zalogowany();
//if ($wynik == true) {
//	header("Location:insert.php");
//	exit;
//}
if ($wynik == false) {
	header("Location:start.php");
	exit;
}
?>

