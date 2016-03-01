<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>.: BlogChat - Chat :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="../images/favicon.ico" />
<?php
include ("config.php");

//se il post non è corretto segnala errore
	if (!isset($_GET["nickname"]))
		die("Errore: stai cercando di accedere alla chat in modo scorretto\n");

	$nickname = $_GET["nickname"];


?>
</head>
<?php
echo "<frameset rows=\"15%,40%,20%,28%\"  border=\"0\" framespacing=\"0\">";
echo "<frame src=\"head.php\" name=\"schermo\"  scrolling=\"no\">";
echo "<frame src=\"schermo.php\" name=\"schermo\" scrolling=\"yes\">";
echo "<frame src=\"plancia.php?nickname=$nickname\" name=\"plancia\" noresize>";
echo "<frame src=\"footer.php\" name=\"schermo\" scrolling=\"no\" >";
echo "</frameset>";
echo "<noframes>Il tuo browser non riesce a visualizzare i frames</noframes>";

?>
  <frameset noresize>

<body>

</body>

</html>