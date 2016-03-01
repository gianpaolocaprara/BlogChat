<?php
	
	//istruzione per disabilitare i messaggi di NOTICE
	error_reporting(0);
	//caricamento file esterni
	require_once("funzioni.php");
	require_once("config.php");
	//inizio (o continuazione) di una sessione
	session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>.: BlogChat - Notizie: <?php echo $_SESSION["utente"]; ?> :.</title>
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">

	//ottiene l'ora corrente del sistema al momento dell'accesso
	function ottieniData(){
		data = new Date();
		ora =data.getHours();
		minuti=data.getMinutes();
		secondi=data.getSeconds();
		giorno = data.getDay();
		mese = data.getMonth();
		date= data.getDate();
		year= data.getYear();
		if(minuti< 10)minuti="0"+minuti;
		if(secondi< 10)secondi="0"+secondi;
		if(year<1900)year=year+1900;
		if(ora<10)ora="0"+ora;
		if(giorno == 0) giorno = " Domenica ";
		if(giorno == 1) giorno = " Lunedì ";
		if(giorno == 2) giorno = " Martedì ";
		if(giorno == 3) giorno = " Mercoledì ";
		if(giorno == 4) giorno = " Giovedì ";
		if(giorno == 5) giorno = " Venerdì ";
		if(giorno == 6) giorno = " Sabato ";
		if(mese == 0) mese = "Gennaio ";
		if(mese ==1) mese = "Febbraio ";
		if(mese ==2) mese = "Marzo ";
		if(mese ==3) mese = "Aprile ";
		if(mese ==4) mese = "Maggio ";
		if(mese ==5) mese = "Giugno ";
		if(mese ==6) mese = "Luglio ";
		if(mese ==7) mese = "Agosto ";
		if(mese ==8) mese = "Settembre ";
		if(mese ==9) mese = "Ottobre ";
		if(mese ==10) mese = "Novembre ";
		if(mese ==11) mese = "Dicembre";
		data_oggi.innerHTML = "Oggi è "+giorno+" "+date+" "+mese+" "+year+" - ora "+ora+":"+minuti+":"+secondi;
	}
		
		//variabili per finestra popup
		var stile = "top=10, left=10, width=800, height=600, status=no, menubar=no, toolbar=no scrollbars=no";
		
		//funzione per aprire finestre popup
		function Popup(apri) 
		{
 			window.open(apri, "", stile);
		}

</script>
</head>

<body onload="ottieniData()">
<div id="topPan">
  <div id="topHeaderPan">
  	<ul>
		<li><a href="homePage_utente.php">Home</a></li>
		<li><a href="componi.php">Componi</a></li>
        <li><a href="archivio.php">Archivio</a></li>
		<li class="company">Notizie</li>
		<li><?php echo"<a href=\"chat/index.php?nickname=". $_SESSION["utente"] ."\">Chat</a>" ?></li>
        <li><a href="javascript:history.back()">Indietro</a></li>
       <li><a href="logout.php">Logout</a></li>
	</ul>
	
   
    <a href="homePage_Utente.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  <?php
		if(!isset($_GET["pagina"]))
				$pagina = 1;
			else
			//altrimenti viene settato il valore di $pagina al valore specificato nell'URI
				$pagina = $_GET["pagina"];
				//numero totale di pagine di cui è costituito l'archivio
			$numero = leggiNumeroPost();
				//ceil(x1)-->Arrotonda al più vicino intero
			$pagine = ceil($numero / $config["post_per_pagina_notizie"]);
			
			if($pagina == 1){
			$contenuto = leggi_post_utenti(0, $config["post_per_pagina_notizie"]);		
			} else {
				$contenuto = leggi_post_utenti(($pagina -1) + $config["post_per_pagina_notizie"], $config["post_per_pagina_notizie"]);
			}
			//se $contenuto contiene almeno un post...
			if (count($contenuto) > 0){
				//fintantoche $contenuto contiene dei post (posti nella variabile $post), gli scrive nel blog
				//la variabile $post è a sua volta un array che contiene (nell'ordine): identificatore, data, titolo e contenuto
				foreach ($contenuto as $post){
					echo "<h2>", $post[2], "</h2>";
					echo "<p class=\"greentext\">", $post[5] , " ", $post[4], "</p>";
					echo "<p class=\"browntext\">", $post[1], "</p>";
					echo "<p>", $post[3], "</p>";
					echo "<ul>";
					echo "<li class=\"more\"><a href=\"leggiPost.php?id_post=". $post[0] ."\">Leggi di più</a></li>";	
					echo "<li class=\"comment\">Commenti: " . numero_Commenti($post[0]) . "</li>";
					echo "</ul>";
					echo "<br /><hr />";
				}
			} else {
					echo "<h2>Attenzione!</h2>";
					echo "<p>Non sono presenti post all'interno di tutto il blog.</p>";
				
			}

		//indice ipertestuale delle pagine
		echo "<p>Pagine: ";
		for ($i = 1; $i <= $pagine; $i++)
			echo "<a href=\"", $_SERVER['PHP_SELF'], "?pagina=", $i, "\" style=\"color:#03F\">", $i,"</a>";
			echo "</p>\n";
			?>
  </div>
  
  <div id="bodyrightPan">
    <div id="loginPan">
    	<h3>
        <?php if(avatarCaricato($_SESSION["utente"])){?>
        <?php echo "<img src=\"".caricamentoAvatar($_SESSION["utente"])."\" alt=\"Avatar personale\" width=\"75\" height\"75\" />";
		} else {?>
        <img src="avatar/avatar.png" alt="Avatar personale" width="75" height="75" />
        <?php } ?>
        Utente: 
        <span><?php echo $_SESSION["utente"]; ?></span>
        </h3>
        <?php $contenuto = recuperaInformazioni($_SESSION["utente"]); 
			echo "<p align=\"center\">Nome: " . $contenuto[1] . "</p>";
			echo "<p align=\"center\">Cognome: " . $contenuto[2] . "</p>";
			echo "<p align=\"center\">Nascita: " . $contenuto[3] . "</p>";
			echo "<p align=\"center\">Email: " . $contenuto[5] . "</p>";

		?>
        <br /><p align="center"><?php echo"<a href=\"cambioAvatar.php?utente=" . $_SESSION["utente"] . "\" style=\"color:#03F\">"; ?>Cambio Avatar<?php echo "</a>"; ?></p>
	</div>
	<div id="loginBottomPan">&nbsp;</div>
	<p class="hours"><a href="#">24/7 hours</a></p>

  </div>
</div>
<div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="homePage_utente.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
	<ul>
        <li><a href="homePage_Utente.php">Home</a>| </li>
        <li><a href="javascript:Popup('riguardoNoi.php')">Riguardo noi</a>| </li>
        <li><a href="javascript:Popup('contatti.php')">Contatti</a>| </li>
        <li><a href="componi.php">Componi</a>| </li>
        <li><a href="archivio.php">Archivio</a>| </li>
        <li><a href="notizie.php">Notizie</a>| </li>
        <li><?php echo"<a href=\"chat/index.php?nickname=". $_SESSION["utente"] ."\">Chat</a>" ?>| </li>
        <li><a href="logout.php">Logout</a></li>
	</ul>
	<ul class="data">
    <li><p id="data_oggi"></p></li>
  </ul>
  </div>
</div>
</body>
</html>