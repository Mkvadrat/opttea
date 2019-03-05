<?php $db=mysql_connect("db2.freehost.com.ua","tea_teaadmin","wUROu6TGK");
mysql_select_db ("tea_tea", $db);



 mysql_query("  INSERT INTO `doc` ( `id` , `foto` , `rar` , `desc` )  VALUES ( '', 'pravo.jpg', 'pravo.zip', 'Внимание' );   ");


?>
