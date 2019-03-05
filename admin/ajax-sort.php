<?php  include ("login/lock.php"); 
	$table = $_POST['table'];
	$id_arr = $_POST['id'];
	$ordName = $_POST['ord'];
	
	foreach($id_arr as $ord => $id){
		mysql_query(" Update `".$table."` set `".$ordName."` = '$ord' where `id` = '$id' ");	
	}
?>