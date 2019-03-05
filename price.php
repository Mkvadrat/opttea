<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='pricelist'",$db);
if (mysql_num_rows($rezult)>0){
		$row = mysql_fetch_array($rezult);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />

<style>
    #price-content-tab {border-collapse: collapse; font-family:verdana;}
    #price-content-tab td {position: relative; border: 1px solid #f5f5f5; padding: 5px; text-align: center}
    #price-content-tab a {position:relative; top:0px; left: 50px;}
    .trH {text-transform: uppercase;}
    .trH td {background: #d5d5d5; color: #fff;}
</style>

<script>
function price() {
    location.href="price_load.php";
}
</script>
<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="cenTd">
    			
            <table width="100%"  border="0"  cellspacing="0" cellpadding="5">
                  <tr>
                   <?php include('blocks/left.php'); ?>
                   <td valign="top" class="center">
                       <table id="price-content-tab" border="0" width="100%">
                           <tr class="trH">
                               <td>Прайс РУБ</td>
                               <td>Прайс ГРН</td>
                               <td>Корзина и цены</td>
                               <td>Сайт ТМ «Крымский Нектар»</td>
                           </tr>
                           <tr>
                               <td>
                                   <a title="Скачать прайс РУБЛИ" href="doc/rub/rub.xlsx" id="doc-save2"></a>
                               </td>
                               <td>
                                   <a title="Скачать прайс ГРИВНЫ" href="doc/grn/grn.xlsx" id="doc-save"></a>
                               </td>
                               <td>
                                   <a title="Корзина" href="order.php" id="cart"></a>
                               </td>
                               <td>
                                   <a target="_blank" href="http://nectar.crimea.ua"><img height="100" src="//nectar.crimea.ua/img/logo.png"></a>
                               </td>
                           </tr>
                       </table>
                       
                   <!--<input type='button' onclick='price()'    value='Сохранить прайс-лист в pdf' />-->
						<?
//							echo('<div style="text-align:center">');
//							  print"</strong>
//								 <a class='button' href='order.php'>Бланк заказа</a>
//							  </center>   
//							  </div>
//							  <div style='width:950px;'>
//							  ";
//								$forprice = mysql_query ("SELECT id, nam_categories FROM categories order by ord",$db);
//										if (mysql_num_rows($forprice)>0){
//											print"
//													<table bgcolor='#FFFFCC' class='prTab' border='0' align='center' style='width:950px;' cellspacing='' cellpadding='3'>
//											";
//															print "<tr ><td class='prHead'>Наименвоание</td>";
//															print "<td class='prHead'>Опт, грн</td>";
//															print "<td class='prHead1'>Роз, грн</td>";
//															print "<td class='prHead'>Опт, руб</td>";
//															print "<td class='prHead1'>Роз, руб</td>";
//															print "<td class='prHead'>Состав</td>";
//															print "<td class='prHead'>Назначение</td></tr>";
//															
//								
//											while ($Rowprice=mysql_fetch_array($forprice)) {		
//												$forprice_tov = mysql_query ("SELECT * FROM Tovari WHERE idCat='$Rowprice[id]' and `cost_roz_ru` > 0 order by ord1 ",$db);
//													if (mysql_num_rows($forprice_tov)>0 ){
//														print "<tr ><td class='prZagGroup' colspan='7' align='center'>$Rowprice[nam_categories]     	</td></tr>";
//														while ($Rowtov=mysql_fetch_array($forprice_tov)) {		
//															if($Rowtov['title'] != '' and $Rowtov['title'] != 'Пусто'){
//																print "<tr ><td class='prTr3'><a href='goods.php?tovar=$Rowtov[id]'>$Rowtov[title]</a></td>";
//																print "<td class='prTr2'>$Rowtov[priceOpt]</td>";
//																print "<td class='prTr2'>$Rowtov[priceRoznica]</td>";
//																print "<td class='prTr2'>$Rowtov[cost_opt_ru]</td>";
//																print "<td class='prTr2'>$Rowtov[cost_roz_ru]</td>";
//																print "<td style='width:100px;' class='prTr'>$Rowtov[Sostav]</td>";
//																print "<td class='prTr'>$Rowtov[Naznachenie]</td></tr>";
//																
//															}
//														}
//													}
//											}
//											print"</table></div>";
//										}
//								?>
                   </td>
                </tr>
                </table>
    </td>
  </tr>
  <tr>
	<?php include('blocks/footer.php'); ?>
  </tr>
</table>

<?php include('blocks/end.php'); ?>
 
</body>
</html>
