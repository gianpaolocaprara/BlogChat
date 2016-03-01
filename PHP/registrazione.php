<?php
	//istruzione per disabilitare i messaggi di NOTICE
	error_reporting(0);
	//caricamento file esterni
	require_once("funzioni.php");
	require_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: BlogChat - Registrazione :.</title>
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
    	<li><a href="index.php">Home</a></li>
		<li class="company">Registrati</li>
	</ul>
	
   
    <a href="index.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  	<h2>Registrazione</h2>
	<p>Questa è la pagina di registrazione a BlogChat. Compila il form qui affianco per registrarti. Cosa aspetti? E' gratis!</p>
  </div>
  
  <div id="bodyrightPan">
    <div id="registerPan">
		<h2>Registrazione <span>BlogChat</span></h2>
		<form action="registrazione.php" method="post" name="registrazione">
        <label>Nome</label><input name="nome" type="text" />
		<label>Cognome</label>
		<input name="cognome" type="text" />
        <label>Nascita</label><input type="date" name="nascita" />
        <label>Nome Utente</label><input name="nome_utente" type="text" />
		<label>Email </label>
		<input name="email" type="text" />
		<label>Password</label><input name="pass" type="password" id="pass" />
        <input name="Input" type="submit" class="button" value="Registrati" />
		</form>
	</div>
	<p class="hours"><a href="javascript:Popup('riguardoNoi.php')">24/7 hours</a></p>

  </div>
</div>
<div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="index.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
	<ul>
  	<li><a href="index.php">Home</a>| </li>
  	<li><a href="javascript:Popup('riguardoNoi.php')">Riguardo noi</a> | </li>
    <li><a href="javascript:Popup('contatti.php')">Contatti</a>| </li>
  	<li><a href="registrazione.php">Registrati</a></li>
	</ul>
	<ul class="data">
    <li><p id="data_oggi"></p></li>
  </ul>
  </div>
</div>
<?php
} else {//la pagina è stata chiamata con il POST
	//chiamata alla funzione registra_utente contenuto nel file "funzioni.php", a cui vengono passati i parametri del form
	if(registra_utente($_POST["nome"] , $_POST["cognome"], $_POST["nascita"], $_POST["nome_utente"], $_POST["email"], $_POST["pass"])){
	//utente o password sono sbagliati = non è presente l'utente all'interno del DB
?>
<div id="topPan">
  <div id="topHeaderPan">
  	<ul>
    	<li><a href="index.php">Home</a></li>
		<li class="company">Registrati</li>
	</ul>
	
   
    <a href="index.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  	<h2>Registrazione</h2>
	<p>Complimenti! Ti sei registrato in maniera corretta al sito BlogChat! Segnati il tuo nome utente e la tua password! Benvenuto e buon divertimento nel nostro sito!</p>
  </div>
  </div>
</div>
<div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="index.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
	<ul>
  	<li><a href="index.php">Home</a>| </li>
  	<li><a href="javascript:Popup('riguardoNoi.php')">Riguardo noi</a> | </li>
    <li><a href="javascript:Popup('contatti.php')">Contatti</a>| </li>
  	<li><a href="registrazione.php">Registrati</a></li>
	</ul>
	<p class="copyright">© 9blog division. All rights reserved.</p>
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
    	<li><a href="index.php">Home</a></li>
		<li class="company">Registrati</li>
	</ul>  
    <a href="index.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>

<div id="bodyPan">
  <div id="bodyleftPan">
  	<h2>Errore</h2>
	<p>Attenzione: Nome Utente già presente all'interno del nostro Database. Ricompila il form con un altro nome utente. Che aspetti?</p>
  </div>
  
  <div id="bodyrightPan">
    <div id="registerPan">
		<h2>Registrazione <span>BlogChat</span></h2>
		<form action="registrazione.php" method="post" name="registrazione">
        <label>Nome</label><input name="nome" type="text" />
		<label>Cognome</label>
		<input name="cognome" type="text" />
        <label>Nascita</label><input type="date" name="nascita" />
        <label>Nome Utente</label><input name="nome_utente" type="text" />
		<label>Email </label>
		<input name="email" type="text" />
		<label>Password</label><input name="pass" type="password" id="pass" />
        <input name="Input" type="submit" class="button" value="Registrati" />
		</form>
	</div>
	<div id="loginBottomPan">&nbsp;</div>
	<p class="hours"><a href="javascript:Popup('riguardoNoi.php')">24/7 hours</a></p>

  </div>
</div>
<div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="index.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
	<ul>
  	<li><a href="index.php">Home</a>| </li>
  	<li><a href="javascript:Popup('riguardoNoi.php')">Riguardo noi</a> | </li>
    <li><a href="javascript:Popup('contatti.php')">Contatti</a>| </li>
  	<li><a href="registrazione.php">Registrati</a></li>
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
