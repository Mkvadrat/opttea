<?php  include ("../blocks/bd.php");  ?>


<?
		$id_cat = $_GET['cat'];
		$k = 1;
		$querySlide=mysql_query("SELECT * FROM `Tovari` where `idCat` = '$id_cat'   ORDER BY `ord1` ASC");
		 if(mysql_num_rows($querySlide)>0 ){
			while($rowSlide=mysql_fetch_array($querySlide)) {  
				$id =   $rowSlide['id'];    
				mysql_query( " UPDATE `Tovari` SET `ord1` = '$k' WHERE `id` ='$id'");
				$k++;
			}
		}
?>