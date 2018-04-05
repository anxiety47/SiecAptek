<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wynik = pg_query_params($db, "SELECT DISTINCT stanowisko FROM projekt.pracownicy WHERE id_apteka=$1",array($id));

echo "<br/><select id='wyborStanowiska'>";
while($rekord=pg_fetch_row($wynik))
{
	echo "<option value='$rekord[0]'>$rekord[0]</option>";
}

echo "</select>";
echo "<br/><br/><button onclick='wypiszStanowisko()'>Zatwierdź</button>";

?>
