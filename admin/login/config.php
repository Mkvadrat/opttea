<?php
$mysql_hostname = "localhost";
$mysql_user = "mkvadrat_opttea";
$mysql_password = "YDRQBbGn";
$mysql_database = "mkvadrat_opttea";


$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

mysql_set_charset('cp1251',$bd);
?>