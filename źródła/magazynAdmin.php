<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Magazyn</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";


echo "Apteka: <select id='magazynApteka'>";
$result = pg_query($db, "SELECT a.id_apteka, m.nazwa, a.adres FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_apteka]'>$row[adres] $row[nazwa]</option>";
echo "</select><br/>";

echo "<br/>Produkt: <select id='magazynProdukt'>";
$result = pg_query($db, "SELECT id_produktu, nazwa, ilosc_w_opakowaniu, postac FROM projekt.produkt");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_produktu]'>$row[nazwa] $row[postac] $row[ilosc_w_opakowaniu]</option>";
echo "</select><br/>";

echo "<br/>Ilość w zamówieniu: <br/><input type='number' min='1' id='magazynIlosc'><br/>";

echo "<br/><button onclick='nowyMagazyn()'>Prześlij</button>";
?>

