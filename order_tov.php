<?php  include ("login/lock.php"); 

mysql_query("set names cp1251");


function sms_outbox($ord){
	$q = mysql_query(" Select * From `ord_status`  ");
	while($r = mysql_fetch_array($q)){
		$st_arr[$r['id']] = $r['name'];
	}
	
	
	$q = mysql_query(" Select * From `sms_outbox` where `id_ord` = '$ord' order by `id` desc ");
	while($r = mysql_fetch_array($q)){
		list($date, $time) = explode(' ', $r['date']);
		list($y, $m, $d) = explode('-', $date);
		$date = $d.'.'.$m.'.'.$y.' '.substr($time,0,5);
		
		$text = $r['text'];
		
		$text = iconv("UTF-8", "CP1251//IGNORE", $text);
		
		$res .= '
				<tr>
					<td>'.$date.'</td>
					<td>'.$text.'</td>
					<td>'.$st_arr[$r['status']].'</td>
					<td>'.$r['phone'].'</td>
					<td>'.$r['email'].'</td>
				</tr>
				';	
	}
	
	return ('
		<table align="center" cellpadding="3" cellspacing="0" border="0">
			<tr id="sms-trH">
				<td>Дата</td>
				<td>СМС</td>
				<td>Статус</td>
				<td>Телефон</td>
				<td>E-mail</td>
			</tr>
			'.$res.'
		</table>
		');
}

$initmail['sms_log'] = 'tamara76@yandex.ru';
$initmail['sms_pas'] = md5('ta24080904');
$initmail['sms_from'] = 'Tea-Crimea';
$initmail['sms_type'] = 3;

if(isset($_POST['get_sms_outbox'])){
	$ord = $_POST['ord'];

	$res = sms_outbox($ord);
	
	$res = iconv('windows-1251', 'UTF-8', $res);
	
	echo $res;

	exit();	
}

if(isset($_POST['save_ur'])){
	$id = $_POST['id'];
	$ur_name = $_POST['ur_name'];
	$ur_inn = $_POST['ur_inn'];
	$ur_ogrn = $_POST['ur_ogrn'];
	$ur_adres = $_POST['ur_adres'];

	mysql_query(" Update `orders` set `ur_name` = '$ur_name', `ur_inn` = '$ur_inn', `ur_ogrn` = '$ur_ogrn', `ur_adres` = '$ur_adres'  where `id` = '$id' ");
	
	header('location:order_tov.php?id='.$id);
}

if(isset($_POST['send_sms'])){
	$ord = $_POST['ord'];
	$st = $_POST['st'];
	$phone = trim($_POST['phone']);
	$phone = preg_replace("/[^0-9]/", '', $phone);
	$email = $_POST['email'];
	$deliv = $_POST['deliv'];
	$deliv_n = $_POST['deliv_n'];
	
	$q = mysql_query(" Select `name` From `ord_status` where `id` = '$st' limit 1; ");
	$r = mysql_fetch_array($q);
	$st_name = $r['name'];
	
	$word_zakaz = 'Заказ №';
	$word_dekl = 'декл:';
	
	$sms_text2 = $word_zakaz.$ord.'\n'.$st_name.$deliv_text.'\ntea-crimea.ru';
	
	$st_name = iconv(  'windows-1251',  'UTF-8',  $st_name);
	$word_zakaz = iconv(  'windows-1251',  'UTF-8',  $word_zakaz);
	$word_dekl = iconv(  'windows-1251',  'UTF-8',  $word_dekl);
	
	if($st == 4) $deliv_text = '\n'.$deliv.', '.$word_dekl.$deliv_n;
	
	
	$sms_text = $word_zakaz.$ord.'\n'.$st_name.$deliv_text.'\ntea-crimea.ru';
	
	
	$sms_text2 = str_replace('\n', ' :lb', $sms_text);
	$sms_text2 = iconv(  'UTF-8',  'windows-1251',   $sms_text2);
	
	$date = date('Y-m-d H:i:s');
	
/*	$body=file_get_contents("https://gate.smsaero.ru/send/?to=".$phone."&text=".urlencode($sms_text2)."&user=".$initmail['sms_log']."&password=".$initmail['sms_pas']."&from=".$initmail['sms_from']."&type=".$initmail['sms_type']);*/
	

	mysql_query(" Insert into `sms_outbox` set `id_ord` = '$ord', `text` = '$sms_text', `text2` = '$sms_text2', `phone` = '$phone', `date` = '$date', `email` = '$email', `status` = '$st' ");
	$sms_id = mysql_insert_id();
	
	$body=file_get_contents("http://".$_SERVER['SERVER_NAME']."/admin/send_sms.php?id=".$sms_id);
	
	echo('sms:'.$body.'['.$sms_text2.']');

	exit();	
}


if(isset($_POST['save_sms'])){
	$ord = $_POST['ord'];
	$st = $_POST['st'];
	$phone = trim($_POST['phone']);
	$email = $_POST['email'];
	$deliv = $_POST['deliv'];
	$deliv_n = $_POST['deliv_n'];
	
	$deliv = iconv( 'UTF-8', 'windows-1251', $deliv);
	
	mysql_query(" Update `orders` set `sms_deliv` = '$deliv', `sms_deliv_n` = '$deliv_n', `phone` = '$phone', `email` = '$email', `status` = '$st' where `id` = '$ord' ");
	
	exit();
}



if(isset($_POST['save_st'])){
	$id = $_POST['id'];
	$st = $_POST['st'];
	
	mysql_query(" Update `orders` set `status` = '$st' where `id` = '$id' ") or die(mysql_error());
	
	exit();
}

if(isset($_POST['recount'])){
	$id = $_POST['id'];
	$c_type = $_POST['type'];
	
	$queryType = mysql_query(" Select * From `orders` where `id` = '$id' limit 1");
	$rowType = mysql_fetch_array($queryType);
	$type = $rowType['type'];
	$cou = $rowType['country'];
	
	$cost_ru_arr[1] = 'cost_roz_ru';
	$cost_ru_arr[2] = 'cost_melk_ru';
	$cost_ru_arr[3] = 'cost_opt_ru';
	$cost_ru_arr[4] = 'large_cost_ru';
        $cost_ru_arr[5] = 'large_cost_ru';
	
	$cost_ua_arr[1] = 'priceRoznica';
	$cost_ua_arr[2] = 'priceMelk';
	$cost_ua_arr[3] = 'priceOpt';
	$cost_ua_arr[4] = 'large_cost_ua';
        $cost_ua_arr[4] = 'large_cost_ua';
	
	/*$q = mysql_query("  Select * From `orders_tov` where `id_ord` = '$id' ") or die(mysql_error());
	while($r = mysql_fetch_array($q)){
		$id_tov = $r['id_tov'];
		$kol = $r['amount'];
		$cost_r = $r['cost_ru'];
		$cost_g = $r['cost_grn'];
		
		if($cou == 'ru'){
			$cost = $cost_r;
		}elseif($cou == 'ua'){
			$cost = $cost_g;
		}
		
		$sum = $cost*$kol;
		
		$sum_sum += $sum;
	}
	
	if($cou == 'ru'){
		if($sum_sum < 5000){
			$new_type = 1;
		}elseif($sum_sum < 20000){
			$new_type = 2;
		}elseif($sum_sum < 300000){
			$new_type = 3;
		}else{
			$new_type = 4;	
		}
	}else if($cou == 'ua'){
		if($sum_sum < 1000){
			$new_type = 1;
		}elseif($sum_sum < 3000){
			$new_type = 2;
		}elseif($sum_sum < 45000){
			$new_type = 3;
		}else{
			$new_type = 4;	
		}
	}*/
	
	
	$sql_cost_ru = $cost_ru_arr[$c_type];
	$sql_cost_ua = $cost_ua_arr[$c_type];
	
	mysql_query(" Update `orders` set `type` = '$c_type' where `id` = '$id' ");
	
	$q = mysql_query(" SELECT `".$sql_cost_ru."` as `cost_ru`,  `".$sql_cost_ua."` as `cost_ua`, `o`.`id` 
						FROM `Tovari` as `t` left join `orders_tov` as `o` on `o`.`id_tov` = `t`.`id` where `o`.`id_ord` = '$id' ");
	while($r = mysql_fetch_array($q)){
		$new_cost_ru = $r['cost_ru'];
		$new_cost_ua = $r['cost_ua'];
		$id_ord_tov = $r['id'];
		
//		if($c_type == 4){
//			$new_cost_ru = round(($new_cost_ru*0.95), 2);
//			$new_cost_ua = round(($new_cost_ua*0.95), 2);
//		}
		

		mysql_query(" Update `orders_tov` set `cost_ru` = '$new_cost_ru', `cost_grn` = '$new_cost_ua' where `id` = '$id_ord_tov' ");
	}
	
	exit();
	
}

if(isset($_POST['add'])){
	$id = $_POST['id'];
	$amount = $_POST['amount'];
	$ord = $_POST['ord'];
	
	$queryExitst = mysql_query(" Select `id` From `orders_tov` where `id_ord` = '$ord' and `id_tov` = '$id' limit 1 ");
	if(mysql_num_rows($queryExitst) > 0){
		$err = 'такой товар уже есть в списке.';	
	}else{
		$queryCost = mysql_query(" Select * From `Tovari` where `id` = '$id' ");
		$rowCost = mysql_fetch_array($queryCost);
		
		$ua_roz = $rowCost['priceRoznica'];
		$ua_mel = $rowCost['priceMelk'];
		$ua_opt = $rowCost['priceOpt'];
                $ru_large_opt = $rowCost['large_cost_ru'];
		
		$ru_roz = $rowCost['cost_roz_ru'];
		$ru_mel = $rowCost['cost_melk_ru'];
		$ru_opt = $rowCost['cost_opt_ru'];
                $ua_large_opt = $rowCost['large_cost_ua'];
		
		$queryType = mysql_query(" Select * From `orders` where `id` = '$ord' limit 1");
		$rowType = mysql_fetch_array($queryType);
		$type = $rowType['type'];
		
		if($type == 1){
			$cost_ua = $ua_roz;
			$cost_ru = $ru_roz;
		}elseif($type == 2){
			$cost_ua = $ua_mel;
			$cost_ru = $ru_mel;
		}if($type == 3){
			$cost_ua = $ua_opt;
			$cost_ru = $ru_opt;
		}if($type == 4){
			$cost_ua = $ua_large_opt;
			$cost_ru = $ru_large_opt;
		}
		
		mysql_query(" INSERT INTO `orders_tov` (`id`, `id_ord`, `id_tov`, `amount`, `cost_ru`, `cost_grn`) 
						VALUES (NULL, '$ord', '$id', '$amount', '$cost_ru', '$cost_ua'); "); 
	}
	
	
	echo $err;
	
	exit;
}

if(isset($_POST['save'])){
	$tov_arr = $_POST['tov'];
	$amount_arr = $_POST['amount'];
	
	foreach($amount_arr as $index => $amount){
		$id = $tov_arr[$index];
		
		mysql_query(" Update `orders_tov` set `amount` = '$amount' where `id` = '$id' ");
	}
	
	$q = mysql_query(" Select `id_ord` as `id` From `orders_tov` where `id` = '$id' ") or die(mysql_error());
	$r = mysql_fetch_array($q);
	$id = $r['id'];
		
	exit;
}

if(isset($_GET['del'])){
	$del = $_GET['del'];	
	$id = $_GET['id'];
	
	mysql_query(" Delete From `orders_tov` where `id` = '$del' ");
	
	header('location:order_tov.php?id='.$id);
}

$Month_Text = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

$id_ord = $_GET['id'];

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

$queryOrd = mysql_query(" Select * From `orders` as `o` where `id` = '$id_ord' limit 1");
$rowOrd = mysql_fetch_array($queryOrd);
if($rowOrd['country'] == 'ru'){
	$country = 'РУБЛИ';
}else if($rowOrd['country'] == 'ua'){
	$country = 'ГРИВНЫ';
}else{
	$country = '';
}

$ur = $rowOrd['ur'];
$ur_name = $rowOrd['ur_name'];
$ur_inn = $rowOrd['ur_inn'];
$ur_ogrn = $rowOrd['ur_ogrn'];
$ur_adres = $rowOrd['ur_adres'];

if($ur == 1){
	$ur_name = htmlspecialchars ($ur_name);
	$ur_table = '
				<form action="order_tov.php" method="post">
					<table align="center" id="ur-table" cellpadding="3" cellspacing="0" border="0">
						<tr>
							<td>Наименование</td>
							<td><input name="ur_name" type="text" value="'.$ur_name.'" /></td>
						</tr>
						<tr>
							<td>ИНН</td>
							<td><input name="ur_inn" type="text" value="'.$ur_inn.'" /></td>
						</tr>
						<tr>
							<td>ОГРН</td>
							<td><input name="ur_ogrn" type="text" value="'.$ur_ogrn.'" /></td>
						</tr>
						<tr>
							<td>Юр. адрес</td>
							<td><input name="ur_adres" type="text" value="'.$ur_adres.'" /></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="сохранить" /></td>
						</tr>
					</table>
					<input type="hidden" name="id" value="'.$id_ord.'" />
					<input type="hidden" name="save_ur" value="1" />
				</form>
				';	
}

$dop = $rowOrd['dop'];
$type = $rowOrd['type'];
$name = $rowOrd['name'];
$email = $rowOrd['email'];
$city = $rowOrd['city'];
$phone = $rowOrd['phone'];
$delivery = $rowOrd['delivery'];

$sel_type[$type] = ' selected="selected" ';

$select = '	
			<select id="sel-type">
				<option '.$sel_type[4].' value="4">Крупный опт</option>
				<option '.$sel_type[3].' value="3">Опт</option>
				<option '.$sel_type[2].' value="2">Мелкий опт</option>
				<option '.$sel_type[1].' value="1">Розница</option>
			</select>
			';

$info = '<b>'.$country.'</b> '.$select.' '. $type_arr[$type].'  '.$name.' '.$phone.' '.$email.' '.$city.' '.$delivery.' <br>'.$dop.'<br><br>';




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script>
	$(function(){
		$('#order-save').click(function(){
			$(this).html('...');
			var amount_arr = [];
			var tov_arr = [];

			$('.amount-tov').each(function(index, element) {
                var id = $(element).data('id');
				var val = $(element).val();
				amount_arr[index] = val;
				tov_arr[index] = id;
            });
			
			$.post('order_tov.php', {save:1, 'amount[]':amount_arr, 'tov[]':tov_arr}, function(data){
				console.log(data);
				top.location = top.location;
			});
		});
		
		$('#add-btn').click(function(){
			var id = $('#add-tov').val();
			var amount = $('#add-amount').val();
			
			if(id == 0){
				alert('выберите товар');
				$('#add-tov').focus();
			}else{
				$.post('order_tov.php', {add:1, id:id, amount:amount, ord:<?=$id_ord?>}, function(data){
					if(data != '') {
						alert(data);
					}else{
						top.location = top.location;	
					}
				});
			}
		});
		
		$('.del').click(function(e){
			if(confirm('Вы уверены?')){
				
			}else{
				e.preventDefault();
				e.stopPropagation();	
			}
		});
		
		$('#sel-type').change(function(){
			var type = $(this).val();
			console.log(type);
			
			$.post('order_tov.php', {recount:1, type:type, id:<?=$id_ord?>}, function(data){
				if(data != '') {
					alert(data);
					console.log(data);
				}else{
					top.location = top.location;	
				}
			});
		});
		
		$('#ord-status').change(function(){
			var t = this;
			var st = $(this).val();
			
			$(t).css('background-color', '#996');
			$.post('order_tov.php', {save_st:1, st:st, id:<?=$id_ord?>}, function(data){
				if(data != '') {
					alert('Ошибка!'+data);
					console.log(data);
				}else{
					$(t).css('background-color', '#fff');
				}
			});
		});
		
		$('#status-send').click(function(){
			var t = this;
			var ord = $(t).data('ord');
			var phone = $('#st-phone').val();
			var email = $('#st-email').val();
			var st = $('#ord-status option:selected').val();
			var deliv = $('#st-delivery').val();
			var deliv_n = $('#st-delivery_n').val();
			
			$(t).html('...');
			$.post('order_tov.php', {send_sms:1, phone:phone, st:st, email:email, deliv:deliv, deliv_n:deliv_n, ord:ord}, function(data){
				$(t).html('Отправить');
				console.log(data);
				sms_outbox();
			});
		});
		
		$('#status-save').click(function(data){
			var t = this;
			var ord = $(t).data('ord');
			var phone = $('#st-phone').val();
			var email = $('#st-email').val();
			var st = $('#ord-status option:selected').val();
			var deliv = $('#st-delivery').val();
			var deliv_n = $('#st-delivery_n').val();
			
			$(t).html('...');
			$.post('order_tov.php', {save_sms:1, phone:phone, st:st, email:email, deliv:deliv, deliv_n:deliv_n, ord:ord}, function(data){
				top.location = top.location;
			});
		});
		
	});
	
	function sms_outbox(){
		$('#sms-outbox').html('<img src="/img/load.gif" />');
		$.post('order_tov.php', {get_sms_outbox:1, ord:<?=$id_ord?>}, function(data){
			$('#sms-outbox').html(data);
		});
	}
</script>

<style>
	body {font-family:Verdana, Geneva, sans-serif;}
	.prTab {border-collapse:collapse;}
	.prTab td {border:1px solid #f5f5f5;}
	.tr:hover {background:#f5f5f5;}
	a {text-decoration:none; color:#333;}
	.prZagGroup {color:#804040;}
	.tr input {width:50px; border:1px solid #ccc; border-radius:2px;}
	.trH {background:#ccc; color:#fff; text-transform:uppercase;}

	
	.table2 {background:#fff; border-collapse:collapse;}
	.table2 td {border:1px solid #f5f5f5;}
	.table2 textarea, .table2 input {width:500px;}
	.table2 select {width:506px;}
	
	#submit, #order-save {background:#d9d9d9; width:200px; padding:4px; text-align:center; text-transform:uppercase; cursor:pointer; border:none; color:#fff;}
	#submit:hover, #order-save:hover {background:#98ce44;}
	#order-save {width:300px; margin:0 auto;}
	h3 {margin-bottom:3px;}
	
	#ur-table  {border-collapse:collapse; background:#fff; margin-bottom:20px;}
	#ur-table  td {border:1px solid #f5f5f5;}
	#ur-table input[type=text] {width:300px;}
	
	#status-div {background:#707a84; padding:10px; margin:20px;}
	#status-div input {border:0px; padding:3px;}
	.st-btn {background:#98ce44; text-transform:uppercase; color:#fff; padding:5px 10px; cursor:pointer; border-radius:3px; box-shadow:1px 1px 2px #6B9827;}
	#st-delivery {width:250px;}
	#st-phone {width:100px;}
	
	#sms-outbox {margin-bottom:20px; background:#CCC; padding:10px 0px;}
	#sms-outbox table {border-collapse:collapse;}
	#sms-outbox table td {border:1px solid #f5f5f5;}
	#sms-trH {text-transform:uppercase; color:#000; background:#d9d9d9;}
</style>

</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="td2">
    	<?
			$q = mysql_query(" Select * From `ord_status` order by `ord` ");
			while($r = mysql_fetch_array($q)){
				if($r['id'] == $rowOrd['status']){
					$sel_status = ' selected="selected" ';	
				}else{
					$sel_status = '';
				}
				$sel .= '<option '.$sel_status.' value="'.$r['id'].'">'.$r['name'].'</option>';	
			}
		?>
    	<h3 align="center">Заказ № <?=$id_ord?> </h3>
        <div align="center"><?=$info?></div>
        
        <?=$ur_table?>
        
        <div id="status-div">
        	<table cellpadding="5" cellspacing="0" border="0">
            	<tr>
                	<td><div style="background-color:#87a0b9;" data-ord="<?=$id_ord?>" class="st-btn" id="status-save">Сохранить</div></td>
                	<td><select id="ord-status"><?=$sel?></select></td>
                	<td><input id="st-delivery" type="text" value="<?=($rowOrd['sms_deliv'])?>" placeholder="Доставка" /></td>
                    <td><input id="st-delivery_n" type="text" value="<?=$rowOrd['sms_deliv_n']?>" placeholder="Номер декларации" /></td>
                    <td><input placeholder="код страны, оператора, тел" id="st-phone" type="text" value="<?=$phone?>" placeholder="Телефон" /></td>
                    <td><input id="st-email" type="text" value="<?=$email?>" placeholder="E-mail" /></td>
                    <td><div class="st-btn" data-ord="<?=$id_ord?>" id="status-send">Отправить</div></td>
                </tr>
            </table>
        </div>
        <div id="sms-outbox">
        	<?
				$outbox = sms_outbox($id_ord);
				echo $outbox;
			?>
        </div>
        
        
        <table align="center" cellpadding="3" cellspacing="0" border="0">
        	<tr>
            	<td>
                	<select id="add-tov">
                    	<option value="0">выберите товар</option>
                        <?
							$query = mysql_query(" Select * From `Tovari` as `t` order by `idCat`, `ord1` ") or die(mysql_error());				  
							while($row = mysql_fetch_array($query)){
								$title = $row['title'];
								$add_id = $row['id'];
								if($title <> '') echo('<option value="'.$add_id.'">'.$title.'</option>');
							}
						?>
                    </select>
                </td>
                <td><input id="add-amount" style="width:50px" type="number" value="1" min="0"></td>
                <td><input id="add-btn" type="button" value="добавить" /></td>
            </tr>
        </table>
        <br />
    	<table  bgcolor='#fff' class="prTab" width="100%" cellpadding="3" cellspacing="0" border="0">
        	<tr class="trH">
            	<td>Товар</td>
                <td>Кол-во</td>
                <td>Ед</td>
                <td>Цена, руб</td>
              	<td>Цена, грн</td>
                <td>Сумма, руб</td>
                <td>Сумма, грн</td>
                <td></td>
            </tr>
            <?
				$query = mysql_query(" Select `o`.*, `t`.`title` as `name` From `orders_tov` as `o`
										left join `Tovari` as `t` on `o`.`id_tov` = `t`.`id`
										where `o`.`id_ord` = '$id_ord'
										order by  `t`.`idCat`, `t`.`ord1`  ") or die(mysql_error());
				while($row = mysql_fetch_array($query)){
					$amount = $row['amount'];
					$cost_ru = $row['cost_ru'];
					$cost_grn = $row['cost_grn'];
					$sum_ru = $cost_ru*$amount;
					$sum_grn = $cost_grn*$amount;
					
					$sum_sum_grn += $sum_grn;
					$sum_sum_ru += $sum_ru;
					$amounts +=$amount;
					
					echo('
						<tr data-id="'.$row['id'].'" class="tr">
							<td>'.$row['name'].'</td>
							<td><input class="amount-tov" data-id="'.$row['id'].'" style="width:50px" type="number" value="'.$amount.'" min="0"></td>
							<td>шт.</td>
							<td>'.$cost_ru.'</td>
							<td>'.$cost_grn.'</td>
							<td>'.$sum_ru.'</td>
							<td>'.$sum_grn.'</td>
							<td align="center">
								<a class="del" href="order_tov.php?id='.$id_ord.'&del='.$row['id'].'"><img src="/img/del.png" height="12" /></a>
							</td>
						</tr>
						');	
				}
				echo('
						<tr class="trH">
							<td></td>
							<td>'.$amounts.'</td>
							<td colspan="3"></td>
							<td>'.$sum_sum_ru.'</td>
							<td>'.$sum_sum_grn.'</td>
							<td></td>
						</tr>
						');	
			?>
        </table>
        <br />
        <div id="order-save">сохранить количество</div>
    	<br /><br />
        <form action="act_email.php" method="post">
            <table class="table2" align="center" width="60%" cellpadding="3" cellspacing="0" border="0">
            	<tr>
                    <td width="150" align="right">Счет</td>
                    <td>
                        <?=$country?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">E-mail</td>
                    <td><input type="text" name="email" value="<?=$rowOrd['email']?>" /></td>
                </tr>
                
               <!-- <tr>
                    <td align="right">Документы</td>
                    <td>
                        <select id="country" name="country">
                            <option value="0">Не прикреплять</option>
                            <option value="1">Уставные домкументы</option>
                        </select>
                    </td>
                </tr>-->
                <tr>
                    <td valign="top" align="right">Текст письма</td>
                    <td><textarea name="message" rows="6"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center"><input id="submit" type="submit" value="отправить" /></td>
                </tr>
            </table>
            <input id="country" name="country" type="hidden" value="<?=$rowOrd['country']?>" />
            <input type="hidden" name="id" value="<?=$id_ord?>" />
        </form>
        <br /><br />
        
    </td>
  </tr>
</table>


  
</body>
</html>
