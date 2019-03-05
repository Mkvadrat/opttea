<?php  include ("login/lock.php");  



if(isset($_POST['idTov'])){
    

	$idTovArr = $_POST['idTov'];	
	$priceOpt_arr = $_POST['priceOpt_arr'];	
	$priceRoznica_arr = $_POST['priceRoznica_arr'];	
	$cost_opt_ru_arr = $_POST['cost_opt_ru_arr'];	
	$cost_roz_ru_arr = $_POST['cost_roz_ru_arr'];	
	$exist_arr = $_POST['exist_arr'];	
	
	$priceMel_arr = $_POST['priceMel_arr'];	
	$cost_mel_ru_arr = $_POST['cost_mel_ru_arr'];	
        
        $large_cost_ru_arr = $_POST['large_cost_ru'];	
	$large_cost_ua_arr = $_POST['large_cost_ua'];
	
	foreach ($idTovArr as $key => $id) {
		$priceOpt = $priceOpt_arr[$id];
		$priceRoznica = $priceRoznica_arr[$id];
		$cost_opt_ru = $cost_opt_ru_arr[$id];
		$cost_roz_ru = $cost_roz_ru_arr[$id];
		$exist = $exist_arr[$id];
		
		$priceMel = $priceMel_arr[$id];
		$cost_mel_ru = $cost_mel_ru_arr[$id];
                
                $large_cost_ru = $large_cost_ru_arr[$id];
		$large_cost_ua = $large_cost_ua_arr[$id];
		
		mysql_query(" Update `Tovari` set `large_cost_ru` = '$large_cost_ru', `large_cost_ua` = '$large_cost_ua', `priceOpt` = '$priceOpt', `priceRoznica` = '$priceRoznica', `cost_opt_ru` = '$cost_opt_ru', `cost_roz_ru` = '$cost_roz_ru', `not_exist` = '$exist',
						`priceMelk` = '$priceMel',  `cost_melk_ru` = '$cost_mel_ru' where `id` = '$id' ") or die(mysql_error());			
	}
	header('location:cost.php');

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
	body {font-family:Verdana, Geneva, sans-serif;}
	.prTab {border-collapse:collapse;}
	.prTab td {border:1px solid #f5f5f5;}
	.tr:hover {background:#f5f5f5;}
	a {text-decoration:none; color:#333;}
	.prZagGroup {color:#804040;}
	.tr input {width:50px; border:1px solid #ccc; border-radius:2px;}
</style>
</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="6" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="td2">
    	<form action="" method="post">
    	<?
		$forprice = mysql_query ("SELECT id, nam_categories FROM categories order by ord");
			if (mysql_num_rows($forprice)>0){
				print"
						<table bgcolor='#fff' class='prTab' border='0' align='center' align='center' cellspacing='' cellpadding='3'>
				";
								print "<tr ><td class='prHead'>Наименвоание</td>";
								print "<td class='prHead'>Наличие</td>";
                                                                print "<td class='prHead'>Круп Опт, грн</td>";
								print "<td class='prHead'>Опт, грн</td>";
								print "<td class='prHead1'>Мел, грн</td>";
								print "<td class='prHead1'>Роз, грн</td>";
                                                                print "<td class='prHead'>Круп Опт, руб</td>";
								print "<td class='prHead'>Опт, руб</td>";
								print "<td class='prHead'>Мел, руб</td>";
								print "<td class='prHead1'>Роз, руб</td>";

								
	
				while ($Rowprice=mysql_fetch_array($forprice)) {		
					$forprice_tov = mysql_query ("SELECT * FROM Tovari WHERE idCat='$Rowprice[id]'  order by ord1 ");
						if (mysql_num_rows($forprice_tov)>0 ){
							$id_cat = $Rowprice[id];
							print "<tr ><td class='prZagGroup' colspan='7' align='center'>$Rowprice[nam_categories]     	</td></tr>";
							while ($Rowtov=mysql_fetch_array($forprice_tov)) {		
								if($Rowtov['title'] != '' and $Rowtov['title'] != 'Пусто'){
									$id = $Rowtov['id'];
									$not_exist = $Rowtov['not_exist'];
									unset($sel_ex);
									$sel_ex[$not_exist] = 'selected="selected" ';
									
									$exist = "
											<select name='exist_arr[".$id."]'>
												<option $sel_ex[0] value='0'>есть</option>
												<option $sel_ex[1] value='1'>нет</option>
											</select> ";
									
									print "<tr class='tr' ><td class='prTr3'><a target='_blank' href='tovar.php?tov=".$id."&cat=".$id_cat."'>$Rowtov[title]</a></td>";
									
									print "<td class='prTr2'>$exist</td>";
                                                                        print "<td class='prTr2'><input type='text' name='large_cost_ua[".$id."]' value='$Rowtov[large_cost_ua]' ></td>";
									print "<td class='prTr2'><input type='text' name='priceOpt_arr[".$id."]' value='$Rowtov[priceOpt]' ></td>";
									print "<td class='prTr2'><input type='text' name='priceMel_arr[".$id."]' value='$Rowtov[priceMelk]' ></td>";
									print "<td class='prTr2'><input type='text' name='priceRoznica_arr[".$id."]' value='$Rowtov[priceRoznica]' ></td>";
                                                                        print "<td class='prTr2'><input type='text' name='large_cost_ru[".$id."]' value='$Rowtov[large_cost_ru]' ></td>";
									print "<td class='prTr2'><input type='text' name='cost_opt_ru_arr[".$id."]' value='$Rowtov[cost_opt_ru]' ></td>";
									print "<td class='prTr2'><input type='text' name='cost_mel_ru_arr[".$id."]' value='$Rowtov[cost_melk_ru]' ></td>";
									print "
										<td class='prTr2'>
												<input type='text' name='cost_roz_ru_arr[".$id."]' value='$Rowtov[cost_roz_ru]' >
												<input type='hidden' name='idTov[".$id."]' value='".$id."' />
												</td>
										</tr>";
									
								}
							}
						}
				}
				print"</table>";
			}
		
		?>
        	<input style="margin:40px auto; background:#98ce44; width:400px; text-align:center; border:none; padding:5px 0px; cursor:pointer; color:#fff; display:block; text-transform:uppercase; font-size:18px;" type="submit" value="сохранить" />
        </form>
    </td>
  </tr>
</table>


  
</body>
</html>