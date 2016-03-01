<?php
//opzioni di configurazione del sistema
//array associativo contenente le informazioni di configurazione
$config = array();

//inserimento all'interno dell'array associativo del db_utente, del db_password, del db_server e del db_database
$config["db_utente"] = "root";
$config["db_password"] = "toor";
$config["db_server"] = "localhost";
$config["db_database"] = "blogchat";

$config["post_per_pagina"] = 5;
$config["post_per_pagina_notizie"] = 20;

//cambio avatar
$formati_immagine = array (".jpg",".gif",".png");
$tipi_immagine = array("image/jpeg","image/gif","image/png");

?>