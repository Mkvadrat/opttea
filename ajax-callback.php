<?php
//include("blocks/db.php"); 
//include("blocks/summ.php"); 

foreach($_POST as $k => $v){
    $v = str_replace('script', '', $v);
    if(!is_array($v)){
        $_POST[$k] = strip_tags($v);
    }
}


$text = $_POST['msg'];
$text = iconv( 'utf-8',  'windows-1251', $text);
$phone = $_POST['phone'];
$email = $_POST['email'];


		
$title = 'Вопрос tea.crimea  '.$email.' '.$phone; 
$to = 'tea-crimea@yandex.ru'; 
//$to = 'maxim-bonart@mail.ru'; 
if($email == ''){
    $from = 'no_email@tea.crimea.ua';
}else{
    $from=$email; 
}

$html = '
        Телефон: '.$phone.'<br />
        E-mail: '.$email.'<br /><br />
            
        Вопрос: '.$text.'<br />
        ';


// функция, которая отправляет наше письмо. 
mail($to, $title, $html,  'From:'.$from. "\r\n" . "MIME-Version: 1.0\r\nContent-type: text/html; charset=windows-1251");


?>