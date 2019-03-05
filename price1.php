<?php 
	include ("blocks/db.php"); /*Соединение с базой*/
	
	$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='pricelist'",$db);
	
	if (!$rezult) {
		
		exit(mysql_error());
	} else {
		if (mysql_num_rows($rezult)>0){
			$row = mysql_fetch_array($rezult);
		}else{
			print"В таблице нет записей";
			exit();
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title><?php echo $row['title']; ?></title>
</head>
<body>

<?php echo $row['text']; ?>


<?php $forprice = mysql_query ("SELECT id, nam_categories FROM categories",$db);
	
	if (!$forprice) {
		print"Произошла ошибка, попробуйте позже";
		exit();
	} else {
		if (mysql_num_rows($forprice)>0){
			print"
				<table border='1' width=100%>
			";
							print "<tr><td>Наименвоание</td>";
							print "<td>Состав</td>";
							print "<td>Назначение</td>";
							print "<td>Цена оптовая</td>";
							print "<td>Мелкий опт</td>";
							print "<td>Розница</td></tr>";
			while ($Rowprice=mysql_fetch_array($forprice)) {		
								
				$forprice_tov = mysql_query ("SELECT title, Sostav, Naznachenie,   	
priceOpt, priceMelk, priceRoznica FROM Tovari WHERE idCat='$Rowprice[id]' ",$db);
	
				if (!$forprice_tov) {
		
					exit();
				} else {
					if (mysql_num_rows($forprice_tov)>0){
						print "<tr><td colspan='6' align='center'>$Rowprice[nam_categories]</td></tr>";
						while ($Rowtov=mysql_fetch_array($forprice_tov)) {		
							print "<tr><td>$Rowtov[title]</td>";
							print "<td>$Rowtov[Sostav]</td>";
							print "<td>$Rowtov[Naznachenie]</td>";
							print "<td>$Rowtov[priceOpt]</td>";
							print "<td>$Rowtov[priceMelk]</td>";
							print "<td>$Rowtov[priceRoznica]</td></tr>";
						}
					}
				}
			}
			print"</table>";
		} else {
			print"В таблице нет записей";
			exit();
		}
	}
?>
<a href="price_load.php">сохранить</a>



 
</body>
</html>
