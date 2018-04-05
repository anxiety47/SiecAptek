<?php
class Apteka {
	//private $id;
	//private $login;
	//private $haslo;
	private $db;

	function _construct() {
		session_start();
		$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
	}
	
	function zaloguj() {
		//print_r($_POST);
		 $_POST['wyborApteki'];
		if (!isset($_POST['wyborApteki']) || !isset($_POST['login']) || !isset($_POST['haslo']))
			return -2;

		$db = pg_connect("host=pascal.fis.agh.edu.pl port=5432 dbname=u5kalota user=u5kalota password=5kalota");
		$dostep = 0;
		$log = $_POST['login'];
		$has = $_POST['haslo'];
		$aptID = $_POST['wyborApteki'];
	
		if($db) 
		{
	
			if($log == "admin" && $has == "apteka" && $aptID == 0)
			{
				$_SESSION['auth'] = 'OK';
				$_SESSION['user'] = 'admin';
				$dostep = -4;	
			}

			else
			{
				$logdb = pg_query_params($db,"SELECT adres FROM projekt.apteki WHERE id_apteka=$1",array($aptID));
				$hasdb = pg_query_params($db,"SELECT m.nazwa FROM projekt.apteki a JOIN projekt.miasta m ON a.id_miasto=m.id_miasto WHERE a.id_apteka=$1",array($aptID));
			
				$loginDB = pg_fetch_assoc($logdb);
				$hasloDB = pg_fetch_assoc($hasdb);		

				if ($log == $loginDB[adres] && $has == $hasloDB[nazwa]) {
					$_SESSION['auth'] = 'OK';
					$_SESSION['user'] = $aptID;
					$dostep = -3;

					echo "Podany login: " . $log;
				}
		
			}
		}
		else {
		echo "brak połączenia z bazą";	return -1;}
		
		return $dostep;
		
	}

	function wyloguj() {
		unset($_SESSION);
		session_destroy();

	}

	function czy_zalogowany() {
		if ( isset( $_SESSION['auth']))
			$ret = $_SESSION['auth'] == 'OK' ? true : false ;
		else 
			$ret = false ; 
      		return $ret ;
	}

}
?>
