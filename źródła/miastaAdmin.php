<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Miasta</i></h3>";

echo "<br/>Miasto: <br/><input type='text' id='miastoNazwa'><br/>";

echo "<br/><button onclick='noweMiasto()'>Prześlij</button>";
?>
