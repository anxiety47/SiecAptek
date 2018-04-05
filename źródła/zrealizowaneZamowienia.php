<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

$wynik = pg_query_params($db, "select projekt.wypisz_zamowienia($1)", array($id));
//$wynik = pg_query($db, "select * from projekt.zamowienie");

echo "<table><tr><th>ID apteki</th><th>ID zamówienia</th><th>nazwa leku</th><th>Producent</th><th>postać</th><th>ilość w opakowaniu</th><th>cena</th><th>ilość w zamówieniu</th><th>imię klienta</th><th>nazwisko klienta</th><th>nr PESEL klienta</th></tr>";

while($rekord=pg_fetch_row($wynik))
{
	
	$rekord[0] = str_replace(")", "",$rekord[0]);
	$rekord[0] = str_replace("(", "",$rekord[0]);
	$rekord[0] = str_replace("\"", "\'",$rekord[0]);


	//$rekord[0] = str_replace(array('(',')'), "",$rekord[0]);        

	$wiersz = explode(",",$rekord[0]);
        echo "<tr>";
	
	foreach ($wiersz as $value) //wiersz zamiast rekord
	{
              	//echo "<td>a</td>";
		 echo "<td>$value</td>";
	}
        echo "</tr>";
	
}
echo "</table>";
?>
