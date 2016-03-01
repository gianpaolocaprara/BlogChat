<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: BlogChat - Riguardo Noi :.</title>
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
	
</script>
</head>

<body onload="ottieniData()">
<div id="topPan">
  <div id="topHeaderPan">
    <a href="index.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>
<div id="bodyPan">
  <div id="bodyleftPan">
  	<h2>Riguardo Noi</h2>
	<p>BlogChat è un sito realizzato a scopo puramente didattico. E' stato creato per il percorso di tesi dal titolo "" del laureando <strong>Caprara Gianpaolo</strong>.</p>
    <p>BlogChat è stato creato in due versioni uguali, ma con linguaggi diversi: PHP & Erlang.</p>
    <p>Anno Accademico di creazione: 2013/2014</p>
    <p>Relatore: Emanuele Covino</p>
  </div>
  
  <div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="index.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
	<ul class="data">
    <li><p id="data_oggi"></p></li>
  </ul>
  </div>
</div>
</body>
</html>