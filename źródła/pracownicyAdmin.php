<?php
session_start();

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

echo "<h3>Dodawanie rekordów do tablicy <i>Pracownicy</i></h3>";
echo "Wszystkie pola są wymagane - jeśli nie zostaną wypełnione rekord nie zostanie dodany do bazy<br/><br/>";

echo "<br/>Imię: <br/><input type='text' id='pracownikImie'><br/>";
echo "<br/>Nazwisko: <br/><input type='text' id='pracownikNazwisko'><br/>";
//echo "<br/>Stanowisko: <br/><input type='text' id='pracownikStanowisko'><br/>";

echo "<br/>Stanowisko: <select id='pracownikStanowisko'>";
$result1 = pg_query($db, "SELECT DISTINCT stanowisko FROM projekt.pracownicy");
while($row1=pg_fetch_assoc($result1))
        echo "<option value='$row1[stanowisko]'>$row1[stanowisko]</option>";
echo "</select><br/>";




echo "<br/>Apteka: <select id='pracownikApteka'>";
$result = pg_query($db, "SELECT a.id_apteka, m.nazwa, a.adres FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto");
while($row=pg_fetch_assoc($result))
        echo "<option value='$row[id_apteka]'>$row[adres] $row[nazwa]</option>";
echo "</select><br/>";

echo "<br/>Pensja: <br/><input type='number' min='1' id='pracownikPensja' value='1000'><br/>";
echo "<br/>Numer telefonu: <br/><input type='text' id='pracownikTelefon'><br/>";
echo "<br/>Numer PESEL: <br/><input type='text' id='pracownikPesel'><br/>";

echo "<br/><button onclick='nowyPracownik()'>Prześlij</button>";
?>
