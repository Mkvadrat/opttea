<?
if(isset($_GET['up'])){
		$ord = $_GET['up'];
		$id = $_GET['id'];
		
		$queryLast=mysql_query("SELECT * FROM `$table` ORDER BY `ord`  DESC  LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$idLast = $rowLast['id'];
		$ordLast = $rowLast['ord'];
		
		$queryNext=mysql_query("SELECT * FROM `$table` ORDER BY `ord` ");
		if(mysql_num_rows($queryNext)>0 ){
			while($rowNext=mysql_fetch_array($queryNext)) {
				$idNext = $rowNext['id'];
				echo('2');
				if($idNext == $id){
					$rowNext=mysql_fetch_array($queryNext);
					$idNext2 = $rowNext['id'];
					$ordNext2 = $rowNext['ord'];
				}
			}
		}

		if($ordLast != $ord){
			mysql_query("  UPDATE `$table` SET `ord` = '$ordNext2'  WHERE `id` = '$id'   ");
			mysql_query("  UPDATE `$table` SET `ord` = '$ord'  WHERE `id` = '$idNext2'   ");
		}
	}
	
	if(isset($_GET['down'])){
		$ord = $_GET['down'];
		$id = $_GET['id'];
		
		$queryLast=mysql_query("  SELECT * FROM `$table` ORDER BY `ord`   LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$idLast = $rowLast['id'];
		$ordLast = $rowLast['ord'];
		
		$queryNext=mysql_query("SELECT * FROM `$table` ORDER BY `ord` DESC  ");
		if(mysql_num_rows($queryNext)>0 ){
			while($rowNext=mysql_fetch_array($queryNext)) {
				$idNext = $rowNext['id'];
			
				if($idNext == $id){
					$rowNext=mysql_fetch_array($queryNext);
					$idNext2 = $rowNext['id'];
					$ordNext2 = $rowNext['ord'];
				}
			}
		}

		if($ordLast != $ord){
			mysql_query("  UPDATE `$table` SET `ord` = '$ordNext2'  WHERE `id` = '$id'   ");
			mysql_query("  UPDATE `$table` SET `ord` = '$ord'  WHERE `id` = '$idNext2'   ");
		}
	}
	
?>