<!DOCTYPE html>
<head>
	<title> Baza logowanie </title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<p>Wybierz aptekę lub zaloguj się jako administrator</p>
	

<?php
$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
if (!$db) echo "Brak połączenia z bazą";

//$result=pg_query($db, "select * from projekt.apteki where id_miasto=2");
$result = pg_query($db, "SELECT a.id_apteka, a.adres, m.nazwa FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto ORDER BY id_apteka");

echo "<ul><form name='daneApteka' action='logowanie.php' method='POST'>";
$counter = 1;

echo "<li><input type='radio' name='wyborApteki' value='0'>Administrator</li>";

while ($row=pg_fetch_assoc($result))
{
	echo "<li><input type='radio' name='wyborApteki' value='$row[id_apteka]'>$row[nazwa]" . " " . "$row[adres]";
	echo "</li>";
	$counter++;
}

echo "<br/>Wprowadź login i hasło:<br/>";
echo "Login: <input type='text' name='login' id='login'><br/>";
echo "Hasło: <input type='password' name='haslo' id='haslo'><br/>";
echo "<input type='submit' name='strGl'></form></ul>";
?>

</body>
</html>
