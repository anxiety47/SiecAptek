<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select * FROM projekt.dyzur WHERE id_apteka=$1", array($id));

while($rekord=pg_fetch_assoc($wynik))
{
	if ($rekord[godzina_rozpoczecia] <= date('Y-m-d H:i:s') && $rekord[godzina_zakonczenia] >= date('Y-m-d H:i:s'))
		$id_dyzur = $rekord[id_dyzuru_apteki];
}

if($id_dyzur == '')
	echo "Obecna godzina(data) wykracza poza godziny pracy apteki";
else
{
	$pracownik = pg_query_params($db,"SELECT p.id_pracownika, p.imie, p.nazwisko, p.nr_telefonu FROM projekt.pracownicy p JOIN projekt.dyzur_pracownik dp ON p.id_pracownika=dp.id_pracownika WHERE dp.id_dyzuru_apteki = $1",array($id_dyzur));
	echo "<table><tr><th>ID pracownika</th><th>imię</th><th>nazwisko</th><th>Numer telefonu</th></tr>";
	while($dane=pg_fetch_row($pracownik))
	{
        	echo "<tr>";
        	foreach ($dane as $value)
                	echo "<td>$value</td>";
        	echo "</tr>";

	}	
	echo "</table>";
}
?>
