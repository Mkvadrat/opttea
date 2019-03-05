<?php  include ("login/lock.php"); 
include ("blocks/number_ru.php"); 

$root = $_SERVER['DOCUMENT_ROOT'];

$smtp_from = 'tea-crimea@yandex.ru';
$smtp_pas = '05111971tea0511197tea';
$smtp_ssl = 'ssl://smtp.yandex.ru';
$smtp_port = 465;
$imap_url = 'imap.yandex.ru';
$imap_port = 993;



$month = array('','января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
list($y, $m, $d) = explode('-', date('Y-m-d'));
$m = (int)$m;
$d = (int)$d;
$date_send = 'от '.$d.' '.$month[$m].' '.$y.' г.';

function xmail( $from, $to, $subj, $text, $filename) {
$f         = fopen($filename,"rb");
$un        = strtoupper(uniqid(time()));
$head      = "From: $from\n";
$head     .= "To: $to\n";
$head     .= "Subject: $subj\n";
$head     .= "X-Mailer: PHPMail Tool\n";
$head     .= "Reply-To: $from\n";
$head     .= "Mime-Version: 1.0\n";
$head     .= "Content-Type:multipart/mixed;";
$head     .= "boundary=\"----------".$un."\"\n\n";
$zag       = "------------".$un."\nContent-Type:text/html;\n";
$zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n";
$zag      .= "------------".$un."\n";
$zag      .= "Content-Type: application/octet-stream;";
$zag      .= "name=\"".basename($filename)."\"\n";
$zag      .= "Content-Transfer-Encoding:base64\n";
$zag      .= "Content-Disposition:attachment;";
$zag      .= "filename=\"".basename($filename)."\"\n\n";
$zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n";
 
return @mail("$to", "$subj", $zag, $head);
}

/*mysql_query("set names utf8");
*/
mysql_set_charset('utf8',$bd); 
$Month_Text = array('', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

$id_ord = $_POST['id'];

$type_arr[1] = 'розница';
$type_arr[2] = 'мелкий опт';
$type_arr[3] = 'опт';
$type_arr[4] = 'крупный отп';

$cost_ru_arr[1] = 'cost_roz_ru';
$cost_ru_arr[2] = 'cost_melk_ru';
$cost_ru_arr[3] = 'cost_opt_ru';
$cost_ru_arr[4] = 'cost_opt_ru';

$cost_ua_arr[1] = 'priceRoznica';
$cost_ua_arr[2] = 'priceMelk';
$cost_ua_arr[3] = 'priceOpt';
$cost_ua_arr[4] = 'priceOpt';

$queryOrd = mysql_query(" Select * From `orders` as `o` where `id` = '$id_ord' limit 1");
$rowOrd = mysql_fetch_array($queryOrd);
$country = $rowOrd['country'];

if($country == 'ru'){
	$currency = 'руб';	
	$country_name = 'Россия';
	if($rowOrd['ur'] == 1){
		$id_text = 4;
	}else{
		$id_text = 2;
	}
	
}else if($country == 'ua'){
	$currency = 'грн';	
	$country_name = 'Украина';
	if($rowOrd['ur'] == 1){
		$id_text = 3;
	}else{
		$id_text = 1;
	}
}else{
	$currency = 'ошибка';
}

$type = $rowOrd['type'];
$name = $rowOrd['name'];
$email = $rowOrd['email'];
$city = $rowOrd['city'];
$phone = $rowOrd['phone'];
$delivery = $rowOrd['delivery'];
$ur_name = $rowOrd['ur_name'];
$ur_inn = $rowOrd['ur_inn'];
$ur_ogrn = $rowOrd['ur_ogrn'];
$ur_adres = $rowOrd['ur_adres'];

$info = $type_arr[$type].' '.$country.' '.$name.' '.$phone.' '.$email.' '.$city.' '.$delivery.'<br><br>';

$queryText = mysql_query(" Select `text` From `counts` as `o` where `id` = '$id_text' limit 1");
$rowText = mysql_fetch_array($queryText);
$count_text = $rowText['text'];

$count_text = str_replace('#name#', $name, $count_text);
$count_text = str_replace('#phone#', $phone, $count_text);
$count_text = str_replace('#email#', $email, $count_text);
$count_text = str_replace('#city#', $city, $count_text);
$count_text = str_replace('#delivery#', $delivery, $count_text);
$count_text = str_replace('#country#', $country_name, $count_text);
$count_text = str_replace('#ur_name#', $ur_name, $count_text);
$count_text = str_replace('#ur_adres#', $ur_adres, $count_text);
$count_text = str_replace('#inn#', $ur_inn, $count_text);
$count_text = str_replace('#ogrn#', $ur_ogrn, $count_text);


if(isset($_POST['email'])){
	mysql_set_charset('utf8',$bd); 
	include "blocks/libmail.php"; // вставляем файл с классом3
	
	$mail_to = $_POST['email'];
	$tema = 'Заказ на сайте tea-crimea.ru';
	$from = 'tea-crimea@yandex.ru';
	$emailContent = $_POST['message'];
	
	$query = mysql_query("  Select `o`.*, `t`.`title` as `name` From `orders_tov` as `o`
                                left join `Tovari` as `t` on `o`.`id_tov` = `t`.`id`
                                where `o`.`id_ord` = '$id_ord'
                                order by `t`.`idCat`, `t`.`ord1`  ") or die(mysql_error());
	while($row = mysql_fetch_array($query)){
		$name = $row['name'];
		$id_tov = $row['id_tov'];
		$amount = $row['amount'];
		$cost_ru = $row['cost_ru'];
		$cost_grn = $row['cost_grn'];
		$sum_ru = $cost_ru*$amount;
		$sum_grn = $cost_grn*$amount;
		
		$cenaS = $cost_grn*$amount;
		$cena2S = $cost_ru*$amount;
		
		
		if($country == 'ru'){
			$summ += $cena2S;
			$cur_cena = $cena2S;
			$cur_cost = $cost_ru;
		}else if($country == 'ua'){
			$summ += $cenaS;
			$cur_cena = $cenaS;
			$cur_cost = $cost_grn;
		}
		$style = 'style="border:1px solid #f5f5f5"';
		$kolSumm += $amount;
		$td .= '
			<tr>
				<td '.$style.' align="left"><a target="_blank" href="http://tea-crimea.ru/goods.php?tovar='.$id_tov.'">'.$name.'</a></td>
				<td '.$style.' align="center">'.$cur_cost.' '.$currency.'</td>
				<td '.$style.'>'.$amount.' шт</td>
				<td '.$style.' align="right">'.$cur_cena.' '.$currency.'</td>
			</tr>
			';
	}
	$td .= '
			<tr style="background:#f5f5f5;">
				<td class="blanktotal" align="right" >Итого:</td>
				<td></td>
				<td class="totals"><b>'.$kolSumm.' шт</b></td>
				<td class="totals"><b>'.$summ.' '.$currency.'</b></td>
				</tr>
			';

				
	$content = '<h3 align="center">Счет № '.$id_ord.' <i style="font-weight:500">'.$date_send.'</i></h3>
				'.$count_text.'
    			<table  bgcolor="#fff" style="border-collapse:collapse;"  width="100%" cellpadding="3" cellspacing="0" border="0">
					<thead>
					<tr style="background:#f5f5f5;">
					<td '.$style.' width="60%">Наименование</td>
					<td '.$style.' width="6%">Цена</td>
					<td '.$style.' width="10%">Кол-во</td>
					<td '.$style.' align="right" width="10%">Сумма</td>
					</tr>
					</thead>
					'.$td.'
				</table>
				<p>Итого к оплате: <b>'.num2str($summ).'</b></p>
				';
	


	include("../MPDF54/mpdf.php");
	
	$mpdf=new mPDF('win-1251','A4','','',10,15,10,15,0,10); 
	$mpdf->useOnlyCoreFonts = true;    // false is default
	$mpdf->SetProtection(array('print'));
	$mpdf->SetTitle("tea-crimea.ru");
	$mpdf->SetAuthor("tea-crimea.ru");
	$mpdf->SetWatermarkText("tea-crimea.ru");
	$mpdf->showWatermarkText = true;
	$mpdf->watermark_font = 'DejaVuSansCondensed';
	$mpdf->watermarkTextAlpha = 0.04;
	$mpdf->SetDisplayMode('fullpage');
	
	
	$fileName = 'tea_crimea.ru_order';
	$mpdf->WriteHTML($content);
	$mpdf->Output('../pdf/'.$fileName.'.pdf','F');
	
	if($mail_to <> ''){
		/*$m = new Mail("utf-8");; // начинаем 
		$m->From( $from ); // от кого отправляется почта 
		$m->To( $mail_to ); // кому адресованно
		$m->Subject( $tema );
		$m->ReplyTo( $from );
		
		$m->Body( $emailContent , "html" );    
		$m->Priority(3) ;    // приоритет письма
		
		$m->Attach( "../pdf/".$fileName.".pdf", "", "application/pdf" ) ; // прикрепленный файл 
		
		$m->smtp_on("smtp.yandex.ru", $from,"5111971", 2525, 10); 
		
		
		$m->Send();    // а теперь пошла отправка
		
		$status = $m->Code2();
		
		echo $status;*/
		//xmail( $from, $mail_to, $tema, $emailContent, '../pdf/'.$fileName.'.pdf');
            
            $file_pdf = $root.'/pdf/'.$fileName.'.pdf';
            
            require_once($root.'/blocks/smtp_class.php'); //подключение модели
            
            $set_email = $mail_to;
            $email_theme = $tema;
            $mail_text = iconv('CP1251','UTF-8',$emailContent);
            $sender_name = 'ТМ "Чаи Крыма"';
	
            $smtp = new SMTP($smtp_ssl, $smtp_port, $smtp_from, $smtp_pas, $sender_name, $imap_url, $imap_port); 	

            $sended=$smtp->send_mail($set_email, $email_theme, $mail_text, array($file_pdf)); // c вложениями

            //echo $sended;

            if ($sended === true){
                $message = 'ok';

            }
	}
	
	header('location:index.php');
		
}



?>