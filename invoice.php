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
$date = date('Y-m-d');

$ur = $_POST['type_lico'];
$ur_name = $_POST['ur_name'];
$ur_inn = $_POST['ur_inn'];
$ur_ogrn = $_POST['ur_ogrn'];
$ur_adres = $_POST['ur_adres'];

if($ur == 0){
	$ur_type = '���. ����';	
}elseif($ur == 1){
	$ur_type = '��. ����';	
	$ur_info = '
				������������: <b>'.$ur_name.'</b><br>
				���: <b>'.$ur_inn.'</b><br>
				����: <b>'.$ur_ogrn.'</b><br>
				��. �����: <b>'.$ur_adres.'</b><br>
				';
}

if($country == 'ru'){
	$currency = '���';	
	//$country_name = '������';
}else if($country == 'ua'){
	$currency = '���';	
	//$country_name = '�������';
}

$type_arr[1] = '�������';
$type_arr[2] = '������ ���';
$type_arr[3] = '���';
$type_arr[4] = '������� ���';
$type_arr[5] = '�����������';

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

//mysql_query(" INSERT INTO `orders` (`id`, `name`, `phone`, `email`, `delivery`, `city`, `date`, `country`, `type`, `dop`) 
//							VALUES (NULL, '$name2', '$tel', '$email', '$dos', '$city', '$date', '$country', '$type', '$dop'); ");
$id_ord = mysql_insert_id();

$Month_Text['1'] = '������';
$Month_Text['2'] = '�������';
$Month_Text['3'] = '�����';
$Month_Text['4'] = '������';
$Month_Text['5'] = '���';
$Month_Text['6'] = '����';
$Month_Text['7'] = '����';
$Month_Text['8'] = '�������';
$Month_Text['9'] = '��������';
$Month_Text['10'] = '�������';
$Month_Text['11'] = '������';
$Month_Text['12'] = '�������';


$dateArr = explode('-',$date);
$mes = $dateArr[1];
$nMes = intval($mes);
$date =  $dateArr[2].' '.$Month_Text[$nMes].' '.$dateArr[0].' �';
$num = $dateArr[2].$mes.substr($dateArr[0],2,2).'/1';
$html='
<b>'.$ur_type.'</b><br>
'.$ur_info.'
���: <b>'.$name2.'</b><br>
�������: <b>'.$tel.'</b><br>
Email: <b>'.$email.'</b><br>
��������: <b>'.$dos.'</b><br>
�����: <b>'.$city.'</b><br>
������: <b>'.$country_name.'</b><br>
�����������: <b>'.$dop.'</b><br>
���: <b>'.$type_arr[$type].'</b><br><br>

<table class="items"  style="font-size: 9pt; border-collapse: collapse;" border="1" cellpadding="8">
<thead>
<tr style="background:#f5f5f5;">
<td width="60%">������������</td>
<td width="6%">����</td>
<td width="10%">���-��</td>
<td align="right" width="10%">�����</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
';
$valuta = ' ���';
$valuta2 = ' ���';
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
			<td align="left"><a target="_blank" href="http://' . $_SERVER['SERVER_NAME'] . '/goods.php?tovar='.$id2.'">'.$name.'</a></td>
			<td align="center">'.$table_cost.' '.$currency.'</td>
			<td>'.$kol.' ��</td>
			<td align="right">'.$cur_cena.' '.$currency.'</td>
			</tr>
			';
	}
}


$html .= '
<!-- END ITEMS HERE -->
<tr style="background:#f5f5f5;">
<td class="blanktotal" align="right" colspan="2">�����:</td>
<td class="totals"><b>'.$kolSumm.' ��</b></td>
<td class="totals"><b>'.$summ.' '.$currency.'</b></td>
</tr>
</tbody>
</table>
<br><br>
';

		
$title = '����� nectar.crimea.ua �'.$id_ord.' '.$country_name.'  '.$summ.' '.$currency.' '.$kolSumm.' ��. ('.$type_arr[$type].')'; 
$to = 'tea-crimea@yandex.ru'; 
//$to = 'maxim-bonart@mail.ru'; 
if($email == ''){
	$from = 'no_email@tea.crimea.ua';
}else{
	$from=$email; 
}


// �������, ������� ���������� ���� ������. 
mail($to, $title, $html,  'From:'.$from. "\r\n" . "MIME-Version: 1.0\r\nContent-type: text/html; charset=windows-1251");
header("Location: http://" . $_SERVER['SERVER_NAME'] .  "/orderok.php");


?>