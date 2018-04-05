<?php
session_start();
//$id = $_SESSION['user'];
//$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
//if (!$db) echo "brak połączenia z bazą";


echo "Wpisz ilość: <input type='text' min='1' id='szukajMniej'> Po naciśnięciu przycisku <b>Zatwierdź</b> pojawi się lista leków, których liczba w magazynie jest mniejsza od podanej";
echo "<br/><button id='przyciskSzukajMniej' onclick='znajdz_mniej_w_magazynie()'>Zatwierdź</button>";

?>
