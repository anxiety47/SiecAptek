<?php
session_start();
$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

//echo "<br/><button onclick='magazyn_mniej_niz_podane()'>Powrót</button><br/>";

$ileMax = $_REQUEST['mniej'];

if($ileMax != null)
{

	$min = pg_query_params($db, "SELECT projekt.min_magazyn($1)", array($id));
	$min_wartosc = pg_fetch_row($min);

	echo "<br/><button onclick='magazyn_mniej_niz_podane()'>Powrót</button><br/>";
	echo "Produkty, których ilość w magazynie jest mniejsza niż ";
	echo $ileMax;

	$wynik = pg_query_params($db, "select p.id_produktu,p.nazwa,p.ilosc_w_opakowaniu,p.cena,p.postac,p.producent,m.ilosc FROM projekt.magazyn m JOIN projekt.produkt p ON m.id_produktu=p.id_produktu WHERE m.id_apteka=$1 AND m.ilosc<$2", array($id, $ileMax));
	

	if($min_wartosc[0] <= $ileMax)
	{
		echo "<table><tr><th>ID produktu</th><th>nazwa</th><th>ilość w opakowaniu</th><th>cena</th><th>postac</th><th>producent</th><th>ilość</th></tr>";
		while($rekord=pg_fetch_row($wynik))
		{
        
        		echo "<tr>";
        		foreach ($rekord as $value)
        		        echo "<td>$value</td>";
        		echo "</tr>";
	
		}
		echo "</table>";
	}
	else
		echo "<br/>Brak";
}
else
{
	echo "Nie wprowadzono danych.";
	echo "<br/><button onclick='magazyn_mniej_niz_podane()'>Powrót</button><br/>";

}
?>
