<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='pricelist'",$db);
if (mysql_num_rows($rezult)>0){
	$row = mysql_fetch_array($rezult);
}

if(isset($_GET['country'])){
	$country = $_GET['country'];
	$sel_cou[$country] = 'selected="selected"';	
}else{
	$country = 'ru';
	$sel_cou[$country] = 'selected="selected"';
}

if(isset($_GET['type'])){
	$type = (int)$_GET['type'];
	$sel_type[$type] = 'selected="selected"';	
}else{
	$type = 3;
	$sel_type[$type] = 'selected="selected"';
}

if($country == 'ru'){
	$currency = 'руб';	
}else if($country == 'ua'){
	$currency = 'грн';	
}

$cost_ru_arr[1] = 'cost_roz_ru';
$cost_ru_arr[2] = 'cost_melk_ru';
$cost_ru_arr[3] = 'cost_opt_ru';
$cost_ru_arr[4] = 'cost_opt_ru';

$cost_ua_arr[1] = 'priceRoznica';
$cost_ua_arr[2] = 'priceMelk';
$cost_ua_arr[3] = 'priceOpt';
$cost_ua_arr[4] = 'priceOpt';

if($country == 'ru'){
	if($type == 1){
		$limitSum = '1500';
	}else if($type == 2){
		$limitSum = '5000';
	}else if($type == 3){
		$limitSum = '20000';
	}else if($type == 4){
		$limitSum = '300000';
	}
	
}else if($country == 'ua'){
	if($type == 1){
		$limitSum = '300';
	}else if($type == 2){
		$limitSum = '1000';
	}else if($type == 3){
		$limitSum = '3000';
	}else if($type == 4){
		$limitSum = '45000';
	}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>
<script type="text/javascript" src="js/basket.js?ver=121"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link href="css/style.css?ver=121" rel="stylesheet" type="text/css" />

<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">

<script>
	var currency = '<?=$currency?>';
	var limitSum = '<?=$limitSum?>';
	
	$(function(){
		$('#type-check input').on('change', function(){
			var val = $('#type-check input:checked').val();
			if(val == 0){
				$('.tr-ur').hide();	
			}else{
				$('.tr-ur').show();	
			}
		});
	});
</script>

<style>
	#dop-text {width:307px;}
	.hide {display:none;}
	#type-check label {cursor:pointer;}
	.tr-ur {display:none;}
</style>
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="cenTd">
    		
            
            
    		<form onsubmit="return vilidOrd()" action="invoice.php" method="post" enctype="multipart/form-data">
    	  <table width="100%" border="0"  cellspacing="0" cellpadding="5">
                  <tr>
                   <?php include('blocks/left.php'); ?>
                   <td valign="top" class="center">
                   <div id="order-info">
                       <p>
                            <div>Розничная цена в рублях от 1500 руб. до 5000 руб., мелкий опт от 5000 руб. до 20000 руб., опт от 20000 руб., крупный опт от 300000 руб</div>
                            <div>Розничная цена в гривнах от 300 грн. до 1000 грн., мелкий опт от 1000 грн. до 3000 грн., опт от 3000 грн., крупный опт от 45000 грн</div>
                        </p>
                        <table width="100%" id="sel-table" cellpadding="3" cellspacing="0" border="0">
                            <tr>
                                <td align="center">
                                    <select id="country">
                                        <option <?=$sel_cou['ru']?> value="ru">Валюта для оплаты - РУБЛИ</option>
                                        <option <?=$sel_cou['ua']?> value="ua">Валюта для оплаты - ГРИВНЫ</option>
                                    </select>
                                </td>
                                <td align="center">
                                    <select id="type">
                                    	<option <?=$sel_type[4]?> value="4">Крупный опт</option>
                                        <option <?=$sel_type[3]?> value="3">Опт</option>
                                        <option <?=$sel_type[2]?> value="2">Мелкий опт</option>
                                        <option <?=$sel_type[1]?> value="1">Розница</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
    	<?
			$queryTov=mysql_query("SELECT *, `Tovari`.`id` as `idTov`, `Tovari`.`img` as `fotoTov`, `categories`.`id` as `idCat`
									FROM  `Tovari` 
									LEFT JOIN  `categories` ON  `Tovari`.`idCat` =  `categories`.`id` 
									WHERE   `not_exist` = 0 and `title` <> ''
									ORDER BY   ord, ord1 ");
			 
			if(mysql_num_rows($queryTov)>0 ){
				$catTitle = '';
				echo('<table align="center" id="pticeTable" cellpadding="3" cellspacing="0" border="0">');
				echo('<tr class="trH">');
				echo('<td>фото</td>');
				echo('<td>Наименование</td>');
				echo('<td>Цена, '.$currency.'</td>');
				echo('<td>Кол-во</td>');
				echo('<td>Сумма, '.$currency.'</td>');
				echo('</tr>');
				while($rowTov=mysql_fetch_array($queryTov)) {
					$cat = $rowTov['nam_categories'];
					$tovar = $rowTov['title'];
					
					$cena2 = $rowTov['cost_opt_ru'];
					$id = $rowTov['idTov'];
					$idCat = $rowTov['idCat'];
					$foto = $rowTov['fotoTov'];
					list($width, $height) = getimagesize('img/tovar/'.$foto);
					
					if($country == 'ru'){
						$field = $cost_ru_arr[$type];
						$cena = $rowTov[$field];
					}else if($country == 'ua'){
						$field = $cost_ua_arr[$type];
						$cena = $rowTov[$field];
					}
					
					if($catTitle <> $cat){
						$catTitle = $cat;
						echo('
						<tr>
							<td colspan="7" class="nameCat"><a href="tea.php?cat='.$idCat.'">'.$cat.'</a></td>
						</tr>
						');
					}
					
					if($type == 4){
						$cena = round(($cena*0.95), 2);	
					}
					
					echo('
						<tr idN="'.$id.'" class="cartTr2">
							<td  w="'.$width.'" foto="img/tovar/'.$foto.'" class="fotoTd"><img src="img/tovar/'.$foto.'" height="15" width="20"</td>
							<td><a href="goods.php?tovar='.$id.'">'.$tovar.'</a></td>
							<td><span id="cena'.$id.'">'.$cena.' </span><input type="hidden" value="'.$cena.'" name="cena['.$id.']"></td>
							<td><input autocomplete="off" name="kol['.$id.']" tov="'.$id.'" class="kol" type="text" size="3" value=""></td>
							<td><span id="summ_'.$id.'"></span><input type="hidden" name="idTov['.$id.']" value="'.$id.'" /></td>
						</tr>
						');
				}
				echo('
					<tr>
						<td colspan="3" align="right"> <b id="allSumm-text"></b> </td>
						<td id="amount"></td>
						<td> <b id="allSumm"></b></td>
					</tr>
					<!--<tr class="sale-tr hide">
						<td colspan="4" align="right"> <b>Скидка 5%:</b> </td>
						<td> <b id="allSumm-sale"></b></td>
					</tr>
					<tr class="sale-tr hide">
						<td colspan="4" align="right"> <b>Итого со скидкой:</b> </td>
						<td> <b id="allSumm-sale2"></b></td>
					</tr>-->
					');
				echo('</table>');
				
				
			}
		?>
        	
        	<table align="center" cellpadding="3" cellspacing="0" border="0" id="baskTable2">
            	<tr>
                	<td></td>
                	<td id="type-check">
                    	<label>
                        	<input name="type_lico" checked="checked" type="radio" value="0" />
                            Физ лицо
                        </label>
                        &nbsp;
                        <label>
                            <input name="type_lico" type="radio" value="1" />
                            Юр лицо
                        </label>
                    </td>
                </tr>
                <tr class="tr-ur">
                	<td>Наименование</td>
                    <td><input placeholder="" id="ur-name" type="text" name="ur_name" value="" size="40" /></td>
                </tr>
                <tr class="tr-ur">
                	<td>ИНН</td>
                    <td><input placeholder="" id="ur-inn" type="text" name="ur_inn" value="" size="40" /></td>
                </tr>
                <tr class="tr-ur">
                	<td>ОГРН</td>
                    <td><input placeholder="" id="ur-ogrn" type="text" name="ur_ogrn" value="" size="40" /></td>
                </tr>
                <tr class="tr-ur">
                	<td>Юр. адрес</td>
                    <td><input placeholder="" id="ur-adres" type="text" name="ur_adres" value="" size="40" /></td>
                </tr>
            	<tr>
                	<td>Фамилия</td>
                    <td><input placeholder="фамилия" id="baskN" type="text" name="name2" value="" size="40" /></td>
                </tr>
				<tr>
                	<td>Имя</td>
                    <td><input placeholder="имя" id="firstname" type="text" name="firstname" value="" size="40" /></td>
                </tr>
				<tr>
                	<td>Отчество</td>
                    <td><input placeholder="отчество" id="patronymic" type="text" name="patronymic" value="" size="40" /></td>
                </tr>
                <tr>
                	<td>Ваш телефон</td>
                    <td><input  id="baskT" type="text" name="tel" value="" size="40" /></td>
                </tr>
				<tr>
                	<td>Ваш email</td>
                    <td><input  id="email" type="text" name="email" value="" size="40" /></td>
                </tr>
                <tr>
                	<td>Способ доставки</td>
                    <td><input  id="baskD" type="text" name="dos" value="" size="40" /></td>
                </tr>
                <tr>
                	<td>Страна</td>
                    <td><input  id="baskCou" type="text" name="country_name" value="" size="40" /></td>
                </tr>
                <tr>
                	<td>Город</td>
                    <td><input  id="baskC" type="text" name="city" value="" size="40" /></td>
                </tr>
                <tr>
                	<td valign="top">Комментарий</td>
                    <td><textarea id="dop-text" name="dop" rows="4"></textarea></td>
                </tr>
                <tr>
                	<td></td>
                	<td><input type="submit" value="отправить" /></td>
                </tr>
            </table>
            
            
             </td>
           </tr>
        </table>
        <input type="hidden" name="country" value="<?=$country?>" />
        <input type="hidden" name="type" value="<?=$type?>" />
        </form>
    </td>
  </tr>
  <tr>
	<?php include('blocks/footer.php'); ?>
  </tr>
</table>

<img id="fotoTov" src=""  />
 
</body>
</html>
