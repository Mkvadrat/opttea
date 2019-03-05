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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Экспорт в Excel</title>


<style>
	
</style>

</head>
<body>

    <table   width="100%" cellpadding="3" cellspacing="0" border="1">
            <tr class="trH">
            <td>№</td>
            <td>Юр/Физ</td>
            <td>Валюта</td>
            <td>Тип</td>
            <td>Дата</td>
            <td>Кол</td>
            <td>Имя</td>
            <td>Телефон</td>
            <td>E-mail</td>
            <td>Доставка</td>
            <td>Город</td>
            <td>Предприятие</td>
            <td>Инн</td>
            <td>Огрн</td>
            <td>Адрес</td>
        </tr>
        <?
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
                            $country = 'руб';
                    }else if($row['country'] == 'ua'){
                            $country = 'грн';
                    }else{
                            $country = '';	
                    }
                    
                    if($row['ur'] == 0){
                        $ur_fiz = 'Физ';
                    }else{
                        $ur_fiz = 'Юр';
                    }
                    
                    $delivery = iconv('windows-1251', 'utf-8', $row['delivery']);
                    $name = iconv('windows-1251', 'utf-8', $row['name']);
					$delivery = iconv('windows-1251', 'utf-8', $row['delivery']);
					$city = iconv('windows-1251', 'utf-8', $row['city']);
					$ur_name = iconv('windows-1251', 'utf-8', $row['ur_name']);
					$ur_inn = iconv('windows-1251', 'utf-8', $row['ur_inn']);
					$ur_ogrn = iconv('windows-1251', 'utf-8', $row['ur_ogrn']);
					$ur_adres = iconv('windows-1251', 'utf-8', $row['ur_adres']);
					
					
					
                    echo('
                        <tr data-id="'.$row['id'].'" class="tr">
                            <td>'.$row['id'].'</td>
                            <td>'.$ur_fiz.'</td> 
                            <td>'.$country.'</td>
                            <td>'.$type_arr[$type].'</td>
                            <td>'.$date.'</td>
                            <td>'.$row['c'].' шт</td>
                            <td>'.$name.'</td>
                            <td>'.$row['phone'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$delivery.'</td>
                            <td>'.$city.'</td>
                            <td>'.$ur_name.'</td>
                            <td>'.$ur_inn.'</td>       
                            <td>'.$ur_ogrn.'</td>   
                            <td>'.$ur_adres.'</td>  
                        </tr>
                        ');	
            }
        ?>
    </table>

    
  
</body>
</html>
