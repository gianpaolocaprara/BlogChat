<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
include("config.php");
include("funzioniChat.php");
echo "<meta http-equiv=\"refresh\" content=\"$time_refresh\">"; 
?>
<title></title>
<link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body bgcolor="#F4F4F4">
<div id="bodyPan">
<div id="bodyleftPan">
<?php

$rows_file_ord=leggiMessaggiChat();

foreach ($rows_file_ord as $info_mess){

$nick=$info_mess[0];
$messaggio = $info_mess[1];
$data = $info_mess[2];

$messaggio = str_replace('[applauso]','<img src="emoticons/applauso.gif">',$messaggio);
$messaggio = str_replace('[angry]','<img src="emoticons/arrabbiato.gif">',$messaggio);
$messaggio = str_replace('[happy]','<img src="emoticons/contento.gif">',$messaggio);
$messaggio = str_replace('[wink]','<img src="emoticons/occhiolino.gif">',$messaggio);
$messaggio = str_replace('[embarassed]','<img src="emoticons/imbarazzo.gif">',$messaggio);
$messaggio = str_replace('[scared]','<img src="emoticons/impaurito.gif">',$messaggio);
$messaggio = str_replace('[tongue]','<img src="emoticons/lingua.gif">',$messaggio);
$messaggio = str_replace('[laugh]','<img src="emoticons/ridere.gif">',$messaggio);
$messaggio = str_replace('[surprise]','<img src="emoticons/sorpreso.gif">',$messaggio);
$messaggio = str_replace('[sad]','<img src="emoticons/triste.gif">',$messaggio);

echo "[" . $data ."] <b style=\"color:#5E9908\">< $nick ></b>: " . $messaggio."<br>";
}

?>
</div>
</div>
</body>
</html>