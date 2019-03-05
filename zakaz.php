<? include ("blocks/db.php");

if(isset($_POST['find_ord'])){
	$c = trim($_POST['contact']);
	$o = trim($_POST['ord']);
	
	if($c == ''){
		$res = ('Введите телефон либо e-mail, указанные при заказе');
	}elseif($o == ''){
		$res = ('Введите номер заказа');
	}else{
		$pos = strpos($c, '@');
		if($pos === false){
                    $c = preg_replace("/[^0-9]/", '', $c);
		}
                
                $q = mysql_query(" Select `id`, `phone` From `orders` order by `id` desc ");
                while($r = mysql_fetch_array($q)){
                    $phone = $r['phone'];
                    $phone = preg_replace("/[^0-9]/", '', $phone);
                    if($phone == $c and $r['id'] == $o){
                        $search_ok = 1;
                        break;
                    }
                }
		
		$q = mysql_query(" Select `id` From `orders` where `id` = '$o' and (`phone` = '$c' or `email` = '$c') limit 1;");
		if(mysql_num_rows($q) > 0){
                    setcookie("order", $o, time()+3600);
                    $res = ('1');
                }elseif($search_ok == 1){
                    setcookie("order", $o, time()+3600);
                    $res = ('1');
                }else{
                    $res = ("Не найдено, попробуйте еще раз, пожалуйста.");	
		}
	}
	
	$res = iconv('windows-1251', 'UTF-8', $res);
	
	echo $res;

	exit();	
}

if($_COOKIE['order'] > 0){
	$ord = $_COOKIE['order'];

	$q = mysql_query(" Select * From `orders` where `id` = '$ord' limit 1; ");
	$rOrd = mysql_fetch_array($q);
	$st = $rOrd['status'];
	
	
	$q = mysql_query(" Select `name` From `ord_status` where `id` = '$st' limit 1; ") or die(mysql_error());
	$r = mysql_fetch_array($q);
	$st_name = $r['name'];
	
	$find_text = '
			<div class="zakaz-line">Статус заказа: <b>'.$st_name.'</b></div>
			';
		
	if($st == 4){
		$find_text .= '
					<div class="zakaz-line">Доставка: '.$rOrd['sms_deliv'].'</div>
					<div class="zakaz-line">Номер декларации: '.$rOrd['sms_deliv_n'].'</div>
					';
	}
}


$row['title'] = 'Отследить заказ';
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
<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">

<style>
	#zakaz-frame {font-family:Verdana, Geneva, sans-serif;}
	.zakaz-line {margin-bottom:10px;}
</style>
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="cenTd">
        <table width="100%" border="0"  cellspacing="0" cellpadding="5">
          <tr>
           <?php include('blocks/left.php'); ?>
           <td valign="top" class="center" id="zakaz-frame">
    			<?
					if($_COOKIE['order'] > 0){
						$ord = $_COOKIE['order'];
						
						echo('<div id="zakaz-search">Отследить другой заказ</div>');
						
						echo('<h1 >Заказ №'.$ord.'</h1>');
						echo $find_text;
						
					}else{
						echo('<div id="zakaz-search">Отследить заказ</div>');	
					}
				
				?>
                        
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
