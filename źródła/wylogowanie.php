<?php
session_start();
function __autoload($class_name) {
        include $class_name . '.php';
}

$uzytkownik = new Apteka;
//echo $uzytkownik->zaloguj();
//echo "cos";
$uzytkownik->wyloguj();
echo "<p> Wylogowałeś się z bazy. Aby zalogować się ponownie, kliknij <a href='start.php'>tutaj</a>.</p>";
?>
