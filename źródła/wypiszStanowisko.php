<?php 
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$pracownik = $_REQUEST['stanowisko'];


$wynik = pg_query_params($db, "SELECT imie, nazwisko, nr_telefonu, pesel, pensja FROM projekt.pracownicy WHERE id_apteka=$1 AND stanowisko=$2",array($id, $pracownik));


echo "<table><tr><th>imię</th><th>nazwisko</th><th>numer telefonu</th><th>PESEL</th><th>pensja</th></tr>";
while($rekord=pg_fetch_row($wynik))
{	echo "<tr>";
	foreach($rekord as $value)
		echo "<td>$value</td>";
	echo "</tr>";
}

echo "</table>";

?>
