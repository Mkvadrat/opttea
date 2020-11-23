<?php  include ($_SERVER['DOCUMENT_ROOT']."/blocks/db.php"); 


if(isset($_GET['id'])){
	$id = $_GET['id'];
	
	header('Content-Type: text/html; charset=utf-8');
	mysql_query("set names utf8");
	
	$initmail['sms_log'] = 'tamara76@yandex.ru';
	$initmail['sms_pas'] = md5('ta24080904');
	$initmail['sms_from'] = 'Tea-Crimea';
	$initmail['sms_type'] = 3;
	
	$q = mysql_query(" Select * From `sms_outbox` where `id` = '$id' ");
	$r = mysql_fetch_array($q);
	$text = $r['text2'];
	$phone = $r['phone'];
	
	//$text = iconv(  'UTF-8', 'windows-1251//IGNORE',   $text);

	
	$body=file_get_contents("https://gate.smsaero.ru/send/?to=".$phone."&text=".urlencode($text)."&user=".$initmail['sms_log']."&password=".$initmail['sms_pas']."&from=".$initmail['sms_from']."&type=".$initmail['sms_type']);
	
	echo $body;
	
	/*echo('body:['.$body.']<br />');
	echo('text:['.$text.']<br />');
	echo('phone:['.$phone.']<br />');*/
}