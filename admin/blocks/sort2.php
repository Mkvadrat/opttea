<?
if(isset($_GET['up'])){
		$ord = $_GET['up'];
		$id = $_GET['id'];
		
		$queryLast=mysql_query("SELECT * FROM `$table` where `idCat` = '$id_cat'  ORDER BY `ord1`  DESC  LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$idLast = $rowLast['id'];
		$ordLast = $rowLast['ord1'];
		
		$queryNext=mysql_query("SELECT * FROM `$table` where `idCat` = '$id_cat'  ORDER BY `ord1` ");
		if(mysql_num_rows($queryNext)>0 ){
			while($rowNext=mysql_fetch_array($queryNext)) {
				$idNext = $rowNext['id'];
			
				if($idNext == $id){
					$rowNext=mysql_fetch_array($queryNext);
					$idNext2 = $rowNext['id'];
					$ordNext2 = $rowNext['ord1'];
				}
			}
		}

		if($ordLast != $ord){
			mysql_query("  UPDATE `$table` SET `ord1` = '$ordNext2'  WHERE `id` = '$id'   ");
			mysql_query("  UPDATE `$table` SET `ord1` = '$ord'  WHERE `id` = '$idNext2'   ");
		}
	}
	
	if(isset($_GET['down'])){
		$ord = $_GET['down'];
		$id = $_GET['id'];
		
		$queryLast=mysql_query("  SELECT * FROM `$table` where `idCat` = '$id_cat'  ORDER BY `ord1`   LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$idLast = $rowLast['id'];
		$ordLast = $rowLast['ord1'];
		
		$queryNext=mysql_query("SELECT * FROM `$table` where `idCat` = '$id_cat'  ORDER BY `ord1` DESC  ");
		if(mysql_num_rows($queryNext)>0 ){
			while($rowNext=mysql_fetch_array($queryNext)) {
				$idNext = $rowNext['id'];
			
				if($idNext == $id){
					$rowNext=mysql_fetch_array($queryNext);
					$idNext2 = $rowNext['id'];
					$ordNext2 = $rowNext['ord1'];
				}
			}
		}

		if($ordLast != $ord){
			mysql_query("  UPDATE `$table` SET `ord1` = '$ordNext2'  WHERE `id` = '$id'   ");
			mysql_query("  UPDATE `$table` SET `ord1` = '$ord'  WHERE `id` = '$idNext2'   ");
		}
	}
	
?>