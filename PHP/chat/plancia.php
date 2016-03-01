<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>
</title>
<!-- Javascript per aggiungere le faccine-->

  <script language="javascript">
  function aggiungi(y)
  {
  espressione=document.form_plancia.messaggio.value;
  new_espressione=espressione + y;
  document.form_plancia.messaggio.value=new_espressione;
  }
  </script>
</head>

<body bgcolor="#FFFFFF">
<?php
include("config.php");
$nickname=$_GET['nickname'];
 ?>
<form name="form_plancia" method="get" action="insert.php">
  <table border="0" cellpadding="3" cellspacing="0">
    <tr> 
      <td width="82" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Messaggio:</b> 
        </font></td>
      <td width="275" rowspan="3" valign="top"> <div align="center"> 
          <textarea name="messaggio" rows="4" cols="40" style="border:1px solid;"></textarea>
        </div></td>
      <td rowspan="3" valign="top"> <div align="center"> <?php echo "<input type=\"hidden\" name=\"nickname\" value=\"$nickname\">"; ?> 
          <table width="200" bordercolor="#000000" bgcolor="#EDFAFA" style="border:1px solid;">
            <tr> 
              <td height="23" colspan="5"><div align="center"><strong><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Clicca 
                  sulle faccine per inserirle</font></strong></div></td>
            </tr>
            <tr> 
              <td height="23"><div align="center"><img src="emoticons/applauso.gif" width="20" height="30" onclick="aggiungi(' [applauso] ')"></div></td>
              <td><div align="center"><img src="emoticons/arrabbiato.gif" width="15" height="15" onclick="aggiungi(' [angry] ')"></div></td>
              <td><div align="center"><img src="emoticons/contento.gif" width="15" height="15" onclick="aggiungi(' [happy] ')"></div></td>
              <td><div align="center"><img src="emoticons/occhiolino.gif" width="15" height="15" onclick="aggiungi(' [wink] ')"></div></td>
              <td><div align="center"><img src="emoticons/imbarazzo.gif" width="19" height="19" onclick="aggiungi(' [embarassed] ')"></div></td>
            </tr>
            <tr> 
              <td height="23"><div align="center"><img src="emoticons/impaurito.gif" width="19" height="19" onclick="aggiungi(' [scared] ')"></div></td>
              <td><div align="center"><img src="emoticons/lingua.gif" width="15" height="15" onclick="aggiungi(' [tongue] ')"></div></td>
              <td><div align="center"><img src="emoticons/ridere.gif" width="15" height="15" onclick="aggiungi(' [laugh] ')"></div></td>
              <td><div align="center"><img src="emoticons/sorpreso.gif" width="19" height="19" onclick="aggiungi(' [surprise] ')"></div></td>
              <td><div align="center"><img src="emoticons/triste.gif" width="20" height="18" onclick="aggiungi(' [sad] ')"></div></td>
            </tr>
          </table>
        </div></td>
    </tr>
    <tr> 
      <td valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name="submit" type="submit" value="invia" style="border:1px solid;background:#EDFAFA;">
        </font></td>
    </tr>
    <tr>
      <td valign="top"><?php echo "<a href=\"../homePage_utente.php\" target=\"_blank\"><img src=\"emoticons/logout.png\" width=\"40\" height=\"40\" border=\"0\"></a>";?></td>
    </tr>
  </table>
</form>

</body>
</html>