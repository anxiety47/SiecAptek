<?php

session_start();

$produkt = $_REQUEST["produkt"];
$ilosc = $_REQUEST["ilosc"];
$apteka = $_REQUEST["apteka"];

$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "brak połączenia z bazą";

if ($ilosc == '' || $apteka == '' || $produkt == '')
        echo "<br/>Nie wszystkie dane są uzupełnione";
else
{

        $wstaw =  pg_query_params($db, "INSERT INTO projekt.magazyn VALUES($1,$2,$3) ON CONFLICT (id_apteka,id_produktu) DO UPDATE SET ilosc=$3", array($apteka,$produkt,$ilosc));

        if( pg_last_error() )
                echo "<br/>Błędne dane - nie wpisano do bazy.";
        else
	{
                echo "<br/>Dane przesłane.";
		$cena = pg_query_params($db,"SELECT cena FROM projekt.produkt WHERE id_produktu=$1",array($produkt));
		$k = pg_fetch_row($cena);
		$c = $k[0] * $ilosc * 0.7;

		$koszty = pg_query_params($db,"UPDATE projekt.apteki SET koszty=koszty+$1 WHERE id_apteka=$2",array($c,$apteka));
		echo pg_last_error();
		if ( pg_last_error() )
			echo "<br/>Błąd w aktualizowaniu kosztów apteki<br/>";
		else
			echo "<br/>Zaktualizowano pole <i>koszty</i> w tabeli <i>apteki</i>.";
	}

}

echo "<br/><br/>Naciśnij przycisk <i>Aktualizuj bazę</i> po wprowadzeniu wszystkich nowych rekordów<br/>";
echo "<button onclick='zakoncz()'>Aktualizuj bazę</button>";

?>

