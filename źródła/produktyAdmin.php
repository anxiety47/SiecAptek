<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Produkt</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";

echo "<br/>Nazwa: <br/><input type='text' id='produktNazwa'><br/>";
echo "<br/>Ilość w opakowaniu: <br/><input type='text' id='produktIlosc'><br/>";
echo "<br/>Cena:<br/><input type='number' lang='en-150' step='0.01' id='produktCena'><br/>";

echo "<br/>Postać leku: <br/><input type='text' id='produktPostac'><br/>";
echo "<br/>Producent: <br/><input type='text' id='produktProducent'><br/>";
echo "<br/><input type='checkbox' id='produktRecepta'>Czy lek jest na receptę?<br/>";


echo "<br/><button onclick='nowyProdukt()'>Prześlij</button>";
?>
