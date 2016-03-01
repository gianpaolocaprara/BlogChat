<?php
	require_once("../config.php");
	require_once("config.php");
	
	//dbConnect: funzione che si connette al database
	function dbConnect(){
		global $config;
		$conn = mysql_connect($config["db_server"], $config["db_utente"], $config["db_password"]) or die ("Errore nella connessione al db: " . mysql_error());
		mysql_select_db($config["db_database"]) or die ("Errore nella selezione del db: " . mysql_error());
		return $conn;	
	}
	
	//inserisce un messaggio inviato alla chat all'interno del DB
	function inserisciMessaggioChat ($nome_utente, $commento){
		$conn = dbConnect();
		
		$sql = "select id from utenti where nome_utente = '" . $nome_utente . "'";		
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id_utente = $riga[0];
		$data = date("Y-m-d H:i:s");
		
		$sql = "insert into chat (id_utente, messaggio, data_commento) values ('" . $id_utente . "','" . $commento . "','" . $data .  "')";	
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());

		mysql_close ($conn);

	}
	
	function leggiMessaggiChat(){
		$conn = dbConnect();
		
		$sql = "select utenti.nome_utente,chat.messaggio,chat.data_commento from chat inner join utenti on chat.id_utente = utenti.id order by data_commento DESC LIMIT 30";	
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$risultato = array();
		while($riga = mysql_fetch_row($risposta))
			$risultato[] = $riga;

			mysql_close($conn);
			return $risultato;
	}

?>