<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: BlogChat - Logout :.</title>
<link rel="shortcut icon" href="images/favicon.ico" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	session_start();
	
	// cancello tutti i dati di sessione
	$_SESSION = array();

	// Cancelliamo l'eventuale cookie di sessione
	if (isset($_COOKIE[session_name()]))
	{
   		setcookie(session_name(), '', time()-42000, '/');
	}
	// distruggiamo la sessione
	session_destroy();
	unset($_SESSION["utente"]);

	
?>
<div id="topPan">
  <div id="topHeaderPan">
    <a href="index.php"><img src="images/logo.png" title="Blog Division" alt="Blog Division" width="191" height="84" border="0" /></a> </div>
</div>
<div id="bodyPan">
  <div id="bodyleftPan">
  <?php
  	echo "<h2>Logout</h2>";
  	echo "<p>Logout effettuato. Verrai riportato alla pagina principale, attendi...</p>";
	header("refresh:3;url=index.php"); 
  ?>
  </div>
  
  <div id="footermainPan">
  <div id="footerPan">
  	<div id="footerlogoPan"><a href="index.php"><img src="images/footerlogo.gif" title="Blog Division" alt="Blog Division" width="189" height="87" border="0" /></a></div>
  </div>
</div>
</body>
</html>