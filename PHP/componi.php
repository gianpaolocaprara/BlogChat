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
<title>.: BlogChat - Componi: <?php echo $_SESSION["utente"]; ?> :.</title>
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
<?php 
	if ($_SERVER['REQUEST_METHOD'] == "GET"){
		//la pagina è stata chiamata con il metodo GET		
?>
<div id="topPan">
  <div id="topHeaderPan">
  	<ul>
    	<li><a href="homePage_utente.php">Home</a></li>
		<li class="company">Componi</li>
        <li><a href="archivio.php">Archivio</a></li>
		<li><a href="notizie.php">Notizie</a></li>
		<li><?php echo"<a href=\"chat/index.php?nickname=". $_SESSION["utente"] ."\">Chat</a>" ?></li>
        <li><a href="javascript:history.back()">Indietro</a></li>
       <li><a href="logout.php">Logout</a></li>
	</ul>
	
   
    <a href="homePage_Utente.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  <h2>Invia un post</h2>
  <p>Inserisci il post che vuoi scrivere all'interno di questo post.</p>
    <!--action = $_SERVER['PHP_SELF']: all'atto dell'invio dei dati, il form richiama se stesso e specisce i dati con il metodo POST-->
    <form method="post" <?php echo "action=\"", $_SERVER['PHP_SELF'], "\""; ?> >
        <label> Titolo</label> <input type="text" name="titolo" size="38"  /><br />
        <label>Contenuto </label> <br />
        <textarea name="contenuto" rows="10" cols="35"></textarea><br />
        <input type="submit" value="Pubblica sul blog!" />
    </form>
    
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
        <li><a href="homePage_Utente.php.php">Home</a>| </li>
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
  <?php
	} else {
		if (!empty($_POST["titolo"]) && !empty($_POST["contenuto"])){
		//salvo i dati attraverso la funzione registra (contenuta nel file "funzioni.php") a cui vengono passati il titolo e il 			contenuto del post che è stato scritto all'interno del form
		registra_post($_POST["titolo"],$_POST["contenuto"], $_SESSION["utente"]);
	?>
   <div id="topPan">
  <div id="topHeaderPan">
  	<ul>
    	<li><a href="homePage_utente.php">Home</a></li>
		<li class="company">Componi</li>
        <li><a href="archivio.php">Archivio</a></li>
		<li><a href="notizie.php">Notizie</a></li>
		<li><?php echo"<a href=\"chat/index.php?nickname=". $_SESSION["utente"] ."\">Chat</a>" ?></li>
        <li><a href="javascript:history.back()">Indietro</a></li>
       <li><a href="logout.php">Logout</a></li>
	</ul>
	
   
    <a href="homePage_Utente.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  <h2>Post registrato</h2>
  <p>Il tuo post è stato salvato correttamente all'interno del DataBase. Gli utenti di BlogChat potranno leggerlo e commentarlo, se vogliono. Torna alla <a href="homePage_utente.php" style="color:#03F">pagina principale</a> per vederlo!</p>
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
        <li><a href="homePage_Utente.php.php">Home</a>| </li>
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
    
<?php
		} else {
?>
			   <div id="topPan">
  <div id="topHeaderPan">
  	<ul>
    	<li><a href="homePage_utente.php">Home</a></li>
		<li class="company">Componi</li>
        <li><a href="archivio.php">Archivio</a></li>
		<li><a href="notizie.php">Notizie</a></li>
		<li><?php echo"<a href=\"chat/index.php?nickname=". $_SESSION["utente"] ."\">Chat</a>" ?></li>
        <li><a href="javascript:history.back()">Indietro</a></li>
       <li><a href="logout.php">Logout</a></li>
	</ul>
	
   
    <a href="homePage_Utente.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  <h2>Post non registrato</h2>
  <p>Attenzione! Post e/o titolo non settati. Torna al <a href="componi.php" style="color:#03F">form</a> e riprova l'inserimento!</p>
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
<?php
		}
	}
?>
</body>
</html>