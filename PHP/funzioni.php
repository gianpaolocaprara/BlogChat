<?php
	require_once("config.php");
	//dbConnect: funzione che si connette al database
	function dbConnect(){
		global $config;
		$conn = mysql_connect($config["db_server"], $config["db_utente"], $config["db_password"]) or die ("Errore nella connessione al db: " . mysql_error());
		mysql_select_db($config["db_database"]) or die ("Errore nella selezione del db: " . mysql_error());
		mysql_query("set names 'utf8'");
		return $conn;	
	}
	
		
	//login_utente: verifica che i dati passati come parametri coincidano con quelli presenti nel database
	function login_utente($utente, $password){
		global $config;
		//inizio (o continuazione) di una sessione
		session_start();
		$_SESSION["utente"] = $utente;
		$conn = dbConnect();
		$sql = "SELECT pass FROM utenti WHERE nome_utente = '" . $utente . "'";
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n" . mysql_error());
		if(mysql_num_rows($risposta) == 0)
			return FALSE;
		
		$riga = mysql_fetch_row ($risposta);
		mysql_close($conn);
		
		return ($password == $riga[0]);	
	}
	
		//registra_utente: funzione che restituisce TRUE se l'utente è stato inserito (e quindi registrato) correttamente sul DB, altrimenti restituisce FALSE se l'utente è già presente (e quindi la registrazione non è andata a buon fine)
	function registra_utente($nome, $cognome, $nascita, $nome_utente, $email, $pass ) {
		
		$conn = dbConnect();
		
		$sql = "SELECT nome_utente FROM utenti WHERE nome_utente = '" . $nome_utente . "'";
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n" . mysql_error());
		//se la risposta alla query è diversa da 0 (quindi contiene un utente con lo stesso nome), restituisce falso
		if(mysql_num_rows($risposta) != 0)
			return FALSE;
	
		
		$sql = "INSERT INTO utenti(nome, cognome, nascita, nome_utente, email, pass) VALUES ('" . $nome . "' , '" . $cognome . "', '" . $nascita. "' , '" . $nome_utente . "' , '" . $email . "' , '" . $pass . "')";
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		
		mysql_close ($conn);
		return TRUE;
		
	}
	
	//funzione che legge i post di un singolo utente
		function leggi_post_utente($da, $quanti, $utente){
		//connessione al DB
		$conn = dbConnect();
		$sql = "select post.id_post, post.`data`, post.nome_post, post.contenuto_post, utenti.nome, utenti.cognome from post inner join utenti on post.id_utente = utenti.id where utenti.nome_utente = '" . $utente . "' order by post.`data` DESC LIMIT " . $da . "," . $quanti;
		//prepara la query da passare al DB
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query " . $sql . "\n" . mysql_error());
		$risultato = array();
		while($riga = mysql_fetch_row($risposta))
			$risultato[] = $riga;

			mysql_close($conn);
			return $risultato;
		
	}
	
	//funzione che legge un singolo post
		function leggi_post($id){
		//connessione al DB
		$conn = dbConnect();
		$sql = "select post.id_post, post.`data`, post.nome_post, post.contenuto_post, utenti.nome, utenti.cognome from post inner join utenti on post.id_utente = utenti.id where post.id_post = " . $id;
		//prepara la query da passare al DB
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query " . $sql . "\n" . mysql_error());
		$risultato = array();
		
		$riga = mysql_fetch_row($risposta);

		mysql_close ($conn);		
		return $riga;
		
	}
	
	//funzione che legge i post di tutti gli utenti per la sezione notizie
		function leggi_post_utenti($da, $quanti){
		//connessione al DB
		$conn = dbConnect();
		$sql = "select post.id_post, post.`data`, post.nome_post, post.contenuto_post, utenti.nome, utenti.cognome from post inner join utenti on post.id_utente = utenti.id order by post.`data` DESC LIMIT " . $da . "," . $quanti;
		//prepara la query da passare al DB
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query " . $sql . "\n" . mysql_error());
		$risultato = array();
		while($riga = mysql_fetch_row($risposta))
			$risultato[] = $riga;

			mysql_close($conn);
			return $risultato;
		
	}
	
		//funzione che registra un post di un determinato utente
	function registra_post ($titolo, $testo , $utente){
		//connessione al database
		$conn = dbConnect();
		
		//seleziona il nome e il cognome dell'utente dal DB
		$sql = "select utenti.id from utenti where utenti.nome_utente ='" . $utente . "'";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id = $riga[0];

		//rende conforme il titolo e il testo
		$titolo = nl2br(htmlentities($titolo));
		$testo = nl2br(htmlentities($testo));
		$data = date("Y-m-d H:i:s");
		//crea la query da passare al DB
		$sql = "INSERT INTO post(id_utente, nome_post, contenuto_post, data) VALUES ('" . $id . "' , '" . $titolo . "' , '" . $testo . "' , '" . $data . "')";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		
		mysql_close ($conn);
		
	}
	
	//funzione che legge i commenti di un determinato post
	function leggi_commenti($id){
		//connessione al database
		$conn = dbConnect();
		
		//seleziona il nome e il cognome dell'utente dal DB
		$sql = "select utenti.nome, utenti.cognome, commenti.commento, commenti.data_commento from utenti inner join commenti on utenti.id = commenti.id_utente where commenti.id_post = " . $id . " ORDER BY commenti.data_commento DESC";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$risultato = array();
		while($riga = mysql_fetch_row($risposta))
			$risultato[] = $riga;

			mysql_close($conn);
			return $risultato;
		
	}
	
	//funzione che registra un commento di un utente a un determinato post
	function registra_commento($id_post, $commento , $utente){
		//connessione al database
		$conn = dbConnect();
		
		//seleziona il nome e il cognome dell'utente dal DB
		$sql = "select utenti.id from utenti where utenti.nome_utente ='" . $utente . "'";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id = $riga[0];

		//rende conforme il titolo e il testo
		$commento = nl2br(htmlentities($commento));
		$data = date("Y-m-d H:i:s");
		//crea la query da passare al DB
		$sql = "INSERT INTO commenti(id_post, id_utente, commento, data_commento) VALUES ('" . $id_post . "' , '" . $id . "' , '" . $commento . "' , '" . $data . "')";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		
		mysql_close ($conn);
		
	}
	
	//funzione che recupera il numero commenti di un determinato post
	function numero_commenti($id_post){
		//connessione al database
		$conn = dbConnect();
		
		//seleziona il nome e il cognome dell'utente dal DB
		$sql = "select count(commenti.commento) from commenti where commenti.id_post = " . $id_post;
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id = $riga[0];
		
		mysql_close ($conn);
		return $id;
		
	}
	
		//funzione che recupera il numero commenti di un determinato post
	function leggiNumeroPost($id_post){
		//connessione al database
		$conn = dbConnect();
		
		//seleziona il nome e il cognome dell'utente dal DB
		$sql = "select count(post.id_post) from post";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id = $riga[0];
		
		mysql_close ($conn);
		return $id;
		
	}
	
	//recupera informazioni utente
	function recuperaInformazioni($nome_utente){
		$conn = dbConnect();
		
		$sql = "select * from utenti where utenti.nome_utente ='". $nome_utente ."'";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);

		mysql_close ($conn);
		return $riga;
	}
	
	//verifica se l'utente ha caricato un avatar o meno
	function avatarCaricato($nome_utente){
		$conn = dbConnect();
		
		$sql = "select nome_immagine from avatar inner join utenti on avatar.id_utente = utenti.id where utenti.nome_utente ='". $nome_utente ."'";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		if(mysql_num_rows($risposta) == 0)
			return FALSE;

		mysql_close ($conn);			
		return TRUE;
		

	}
	
	//carica l'avatar dell'utente
	function caricamentoAvatar($nome_utente){
		$conn = dbConnect();
		
		$sql = "select nome_immagine from avatar inner join utenti on avatar.id_utente = utenti.id where utenti.nome_utente ='". $nome_utente ."'";
		//esegue la query
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);

		return "avatar/".$riga[0];
		
		mysql_close ($conn);

	}
	
	//funzione che registra il nuovo avatar dell'utente
	function registraAvatar($nome_utente, $nome_file, $tmp_nome){
		$conn = dbConnect();

		$sql = "select id from utenti where nome_utente = '" . $nome_utente . "'";		
		$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
		$riga = mysql_fetch_row ($risposta);
		
		$id_utente = $riga[0];
		
		if(!avatarCaricato($nome_utente)){
			$sql = "insert into avatar(id_utente, nome_immagine) values ('" . $id_utente . "','" . $nome_file . "')";
			$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
			move_uploaded_file($tmp_nome, "avatar" . "/" . $nome_file);
		} else {
			$conn = dbConnect();
			$sql = "select nome_immagine from avatar where id_utente = '" . $id_utente . "'";		
			$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
			$riga = mysql_fetch_row ($risposta);
			$immagine_vecchia = $riga[0];
			unlink("avatar/" . $immagine_vecchia);
			
			$sql = "update avatar set nome_immagine='" . $nome_file . "' where id_utente=" . $id_utente . "";
			$risposta = mysql_query($sql) or die ("Errore nella query: " . $sql . "\n!" . mysql_error());
			move_uploaded_file($tmp_nome, "avatar/" . $nome_file);
		}
		
		mysql_close ($conn);
		
	}
	
	//verifica se $nomefile ha il tipo di un immagine
	function controllaTipo($nomefile){
		global $tipi_immagine;
		foreach ($tipi_immagine as $tipo)
		//la funzione strrpos parte dalla fine della stringa 
			if (strrpos ($nomefile, $tipo) !== FALSE)
				return TRUE;
		return FALSE;	
	}
?>