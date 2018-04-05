<?php
session_start();
$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wynik = pg_query($db, "select distinct nazwa from projekt.produkt");

echo "Wybierz lek:<br/>";

echo "<select id='wybierzLek'>";
while($rekord=pg_fetch_row($wynik))
{
	echo "<option value='$rekord[0]'>$rekord[0]</option>";
}
echo "</select>";

echo "<button id='szczegolyOLeku' onclick='szczegolyOLeku()'> Zatwierdź </button>";
//echo "<button id='zakoncz' onclick='zakoncz_zamowienie()'>Anuluj</button>";

?>
