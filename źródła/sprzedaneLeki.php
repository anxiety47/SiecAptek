<?php
session_start();

$id = $_SESSION['user'];
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";


$wynik = pg_query_params($db, "select projekt.sprzedane_produkty($1)", array($id));

echo "<table><tr><th>ID produktu</th><th>nazwa</th><th>postać</th><th>ilość w opakowaniu</th><th>suma sprzedanych opakowań</th></tr>";

//echo pg_last_error();

while($rekord=pg_fetch_row($wynik))
{

        $rekord[0] = str_replace(")", "",$rekord[0]);
        $rekord[0] = str_replace("(", "",$rekord[0]);
        //$rekord[0] = str_replace("\"", "\'",$rekord[0]);
		
        $wiersz = explode(",",$rekord[0]);
        echo "<tr>";

	echo "<td>$wiersz[0]</td>";
	$lek = pg_query_params($db, "select nazwa, postac, ilosc_w_opakowaniu from projekt.produkt where id_produktu=$1", array($wiersz[0]));
	$produkt=pg_fetch_assoc($lek);

	echo "<td>$produkt[nazwa]</td>";
	echo "<td>$produkt[postac]</td>";
	echo "<td>$produkt[ilosc_w_opakowaniu]</td>";

	echo "<td>$wiersz[1]</td>";

	
        echo "</tr>";

}
echo "</table>";

?>
