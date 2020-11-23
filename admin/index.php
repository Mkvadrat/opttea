<?php  include ("login/lock.php");  

$Month_Text = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

$type_arr[1] = 'розница';
$type_arr[2] = 'мел. опт';
$type_arr[3] = 'опт';
$type_arr[4] = 'круп. опт';

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
		$('.tr').click(function(){
			var id = $(this).data('id');
			top.location = 'order_tov.php?id='+id;
		});
	});
</script>

<style>
	body {font-family:Verdana, Geneva, sans-serif; font-size:12px;}
	.prTab {border-collapse:collapse;}
	.prTab td {border:1px solid #f5f5f5;}
	.tr:hover {background:#f5f5f5;}
	a {text-decoration:none; color:#333;}
	.prZagGroup {color:#804040;}
	.tr input {width:50px; border:1px solid #ccc; border-radius:2px;}
	.trH {background:#ccc; color:#fff; text-transform:uppercase;}
	.tr {cursor:pointer;}
</style>

</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="td2">
    	<h3 align="center">Заказы</h3>
    	<table  bgcolor='#fff' class="prTab" width="100%" cellpadding="3" cellspacing="0" border="0">
        	<tr class="trH">
            	<td>№</td>
                <td>Валюта</td>
                <td>Тип</td>
                <td>Дата</td>
                <td>Кол</td>
                <td>Фамилия</td>
				<td>Имя</td>
				<td>Отчество</td>
                <td>Контакты</td>
                <td>Статус</td>
                <td>Доставка</td>
                <td>Город</td>
            </tr>
            <?
			
				$q = mysql_query(" Select * From `ord_status` order by `ord` ");
				while($r = mysql_fetch_array($q)){
					$st_arr[$r['id']] = $r['name'];
				}
				
				$query = mysql_query(" Select *, `c` From `orders` as `o`
										left join (Select sum(`amount`) as `c`, `id_ord` From `orders_tov` group by `id_ord`) as `t` on `t`.`id_ord` = `o`.`id`
										order by `o`.`id` desc ") or die(mysql_error());
				while($row = mysql_fetch_array($query)){
					$dateArr = explode('-', $row['date']);
					$mes = $dateArr[1];
					$nMes = intval($mes);
					$date =  $dateArr[2].' '.$Month_Text[$nMes].' '.$dateArr[0].' г';
					
					$type = $row['type'];
					
					if($row['country'] == 'ru'){
						$country = '<img src="/img/ru.png" />';
					}else if($row['country'] == 'ua'){
						$country = '<img src="/img/ua.png" />';
					}else{
						$country = '';	
					}
					
					
					echo('
						<tr data-id="'.$row['id'].'" class="tr">
							<td>'.$row['id'].'</td>
							<td>'.$country.'</td>
							<td>'.$type_arr[$type].'</td>
							<td>'.$date.'</td>
							<td>'.$row['c'].' шт</td>
							<td>'.$row['name'].'</td>
							<td>'.$row['firstname'].'</td>
							<td>'.$row['patronymic'].'</td>
							<td><div>'.$row['phone'].'</div>'.$row['email'].'</td>
							<td>'.$st_arr[$row['status']].'</td>
							<td>'.$row['delivery'].'</td>
							<td>'.$row['city'].'</td>
						</tr>
						');	
				}
			?>
        </table>
    	
        
    </td>
  </tr>
</table>


  
</body>
</html>
