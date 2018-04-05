<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Apteki</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";


echo "miasto: <select id='aptekaMiasto'>";
$result = pg_query($db, "SELECT * FROM projekt.miasta");
while($row=pg_fetch_assoc($result))
	echo "<option value='$row[id_miasto]'>$row[nazwa]</option>";
echo "</select><br/>";

echo "<br/>Adres: <br/><input type='text' id='aptekaAdres'><br/>";
echo "<br/>Numer telefonu: <br/><input type='text' id='aptekaTelefon'><br/>";

echo "<br/><button onclick='nowaApteka()'>Prześlij</button>";
?>
