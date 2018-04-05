<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Dyżury</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";


echo "Apteka: <select id='dyzurApteka'>";
$result = pg_query($db, "SELECT a.id_apteka, m.nazwa, a.adres FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_apteka]'>$row[adres] $row[nazwa]</option>";
echo "</select><br/>";

echo "<br/>Dzień: <br/><input type = 'date' id='dyzurDzien'><br/>";
echo "<br/>Godzina rozpoczęcia dyżuru: <br/><input type='time' id='dyzurStart'><br/>";
echo "<br/>Godzina zakończenia dyżuru: <br/><input type='time' id='dyzurStop'><br/>";

echo "<br/><button onclick='nowyDyzur()'>Prześlij</button>";
?>

