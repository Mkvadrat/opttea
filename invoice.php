<?php
include("blocks/db.php"); 
include("blocks/summ.php"); 

foreach($_POST as $k => $v){
    $v = str_replace('script', '', $v);
    if(!is_array($v)){
        $_POST[$k] = strip_tags($v);
    }
}


$dop = $_POST['dop'];
$cenaAr = $_POST['cena'];
$cena2Ar = $_POST['cena2'];
$kolAr = $_POST['kol'];
$idArr = $_POST['idTov'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$nameArr = $_POST['name'];
$name2 = $_POST['name2'];
$dos = $_POST['dos'];
$city = $_POST['city'];
$email = $_POST['email'];
$country = $_POST['country'];
$country_name = $_POST['country_name'];
$type = $_POST['type'];

$ur = $_POST['type_lico'];
$ur_name = $_POST['ur_name'];
$ur_inn = $_POST['ur_inn'];
$ur_ogrn = $_POST['ur_ogrn'];
$ur_adres = $_POST['ur_adres'];

if($ur == 0){
	$ur_type = 'Физ. лицо';	
}elseif($ur == 1){
	$ur_type = 'Юр. лицо';	
	$ur_info = '
				Наименование: <b>'.$ur_name.'</b><br>
				ИНН: <b>'.$ur_inn.'</b><br>
				ОГРН: <b>'.$ur_ogrn.'</b><br>
				Юр. адрес: <b>'.$ur_adres.'</b><br>
				';
}

$date = date('Y-m-d');

if($country == 'ru'){
	$currency = 'руб';	
	//$country_name = 'Россия';
}else if($country == 'ua'){
	$currency = 'грн';	
	//$country_name = 'Украина';
}

$type_arr[1] = 'розница';
$type_arr[2] = 'мелкий опт';
$type_arr[3] = 'опт';
$type_arr[4] = 'крупный опт';
$type_arr[5] = 'франчайзинг';

$cost_ru_arr[1] = 'cost_roz_ru';
$cost_ru_arr[2] = 'cost_melk_ru';
$cost_ru_arr[3] = 'cost_opt_ru';
$cost_ru_arr[4] = 'large_cost_ru';
$cost_ru_arr[5] = 'large_cost_ru';

$cost_ua_arr[1] = 'priceRoznica';
$cost_ua_arr[2] = 'priceMelk';
$cost_ua_arr[3] = 'priceOpt';
$cost_ua_arr[4] = 'large_cost_ua';
$cost_ua_arr[5] = 'large_cost_ua';

mysql_query(" INSERT INTO `orders` (`id`, `name`, `phone`, `email`, `delivery`, `city`, `date`, `country`, `type`, `dop`, `ur`, `ur_name`, `ur_ogrn`, `ur_inn`, `ur_adres`) 
							VALUES (NULL, '$name2', '$tel', '$email', '$dos', '$city', '$date', '$country', '$type', '$dop', '$ur', '$ur_name', '$ur_ogrn', '$ur_inn', '$ur_adres'); ");
$id_ord = mysql_insert_id();

$Month_Text['1'] = 'января';
$Month_Text['2'] = 'февраля';
$Month_Text['3'] = 'марта';
$Month_Text['4'] = 'апреля';
$Month_Text['5'] = 'мая';
$Month_Text['6'] = 'июня';
$Month_Text['7'] = 'июля';
$Month_Text['8'] = 'августа';
$Month_Text['9'] = 'сентября';
$Month_Text['10'] = 'октября';
$Month_Text['11'] = 'ноября';
$Month_Text['12'] = 'декабря';


$dateArr = explode('-',$date);
$mes = $dateArr[1];
$nMes = intval($mes);
$date =  $dateArr[2].' '.$Month_Text[$nMes].' '.$dateArr[0].' г';
$num = $dateArr[2].$mes.substr($dateArr[0],2,2).'/1';
$html='
<b>'.$ur_type.'</b><br>
'.$ur_info.'
Имя: <b>'.$name2.'</b><br>
Телефон: <b>'.$tel.'</b><br>
Email: <b>'.$email.'</b><br>
Доставка: <b>'.$dos.'</b><br>
Город: <b>'.$city.'</b><br>
Страна: <b>'.$country_name.'</b><br>
Комментарий: <b>'.$dop.'</b><br>
Тип: <b>'.$type_arr[$type].'</b><br><br>

<table class="items"  style="font-size: 9pt; border-collapse: collapse;" border="1" cellpadding="8">
<thead>
<tr style="background:#f5f5f5;">
<td width="60%">Наименование</td>
<td width="6%">Цена</td>
<td width="10%">Кол-во</td>
<td align="right" width="10%">Сумма</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
';
$valuta = ' грн';
$valuta2 = ' руб';
$summ = 0;	
$summ2 = 0;	
$kolSumm = 0;

$countTov = count($idArr)-1;
foreach ($idArr as $key => $id2) {
	
	$kol = $kolAr[$id2];
	
	
	
	$queryW=mysql_query("SELECT * FROM  `Tovari` where `id` = '$id2' ");
	$RowW=mysql_fetch_array($queryW);
	$name = $RowW['title'];
	
	$field = $cost_ua_arr[$type];
	$cena = $RowW[$field];
	
	$field = $cost_ru_arr[$type];
	$cena2 = $RowW[$field];
	
//	if($type == 4){
//		$cena = round(($cena*0.95), 2);	
//		$cena2 = round(($cena2*0.95), 2);	
//	}

		
	if($kol > 0){
		
		mysql_query(" INSERT INTO `orders_tov` (`id`, `id_ord`, `id_tov`, `amount`, `cost_ru`, `cost_grn`) 
										VALUES (NULL, '$id_ord', '$id2', '$kol', '$cena2', '$cena'); ");
										
		$cenaS = $cena*$kol;
		$cena2S = $cena2*$kol;
		
		if($country == 'ru'){
			$summ += $cena2S;
			$cur_cena = $cena2S;
			
			$table_cost = $cena2;
		}else if($country == 'ua'){
			$summ += $cenaS;
			$cur_cena = $cenaS;
			$table_cost = $cena;
		}
		
		$kolSumm += $kol;
		
		
		$html .= '
			<tr>
			<td align="left"><a target="_blank" href="http://tea-crimea.ru/goods.php?tovar='.$id2.'">'.$name.'</a></td>
			<td align="center">'.$table_cost.' '.$currency.'</td>
			<td>'.$kol.' шт</td>
			<td align="right">'.$cur_cena.' '.$currency.'</td>
			</tr>
			';
	}
}


$html .= '
<!-- END ITEMS HERE -->
<tr style="background:#f5f5f5;">
<td class="blanktotal" align="right" colspan="2">Итого:</td>
<td class="totals"><b>'.$kolSumm.' шт</b></td>
<td class="totals"><b>'.$summ.' '.$currency.'</b></td>
</tr>
</tbody>
</table>
<br><br>
';

		
$title = 'Заказ tea-crimea.ru №'.$id_ord.' '.$country_name.'  '.$summ.' '.$currency.' '.$kolSumm.' шт. ('.$type_arr[$type].')'; 
$to = 'tea-crimea@yandex.ru'; 
//$to = 'maxim-bonart@mail.ru'; 
if($email == ''){
	$from = 'no_email@tea-crimea.ru';
}else{
	$from=$email; 
}


// функция, которая отправляет наше письмо. 
mail($to, $title, $html,  'From:'.$from. "\r\n" . "MIME-Version: 1.0\r\nContent-type: text/html; charset=windows-1251");
header("Location:http://tea-crimea.ru/orderok.php");


?>