<html>

<head>
  <title>Inserimento del messaggio</title>
</head>

<body>

<?php
include("config.php");
include("funzioniChat.php");

$nickname=$_GET['nickname'];
$messaggio=$_GET['messaggio'];
$url="plancia.php";

	if ($messaggio=="")
	{
		Header("Location: $url?nickname=$nickname");
	}
		else
		{
			$messaggio=ereg_replace("\n"," ",$messaggio);	
			inserisciMessaggioChat($nickname, $messaggio);
			Header("Location: $url?nickname=$nickname");
		}
?>

</body>

</html>