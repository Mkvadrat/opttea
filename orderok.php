<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
	$row = mysql_fetch_array($rezult);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="400" class="cenTd">
    			
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <?php include('blocks/left.php'); ?>
                    <td valign="top" class="center">
                    	<div class="cenText">
                        	<h3 style="font-family:Verdana, Geneva, sans-serif; color:#666;" align="center">Ваш заказ принят в обработку. Спасибо<br /><br />Вам на почту придет письмо со счетом для оплаты</h3>
                            <h2  style="font-family:Verdana, Geneva, sans-serif; color:#666;" align="center">
                            	Вы также можете заказать крымские восточные сладости здесь &darr;
                            	
                            </h2>
                            <div align="center">
                            	<a target="_blank" href="//nectar-crimea.ru"><img width="200" src="//nectar-crimea.ru/img/logo.png" /></a>
                            </div>
                            
                         </div>
                    </td>
                    <td>
                    
                    	<div  class="rSide2">   <img class="imgUp" name="imgUp" src="img/buttonUp.png" onmouseover="scroll_up('rightScr'), imgOn('imgUp')" onmouseout="scroll_stop('rightScr'), imgOff('imgUp')" ; />
                            <div class="rightSide"  id="rightScr">
                                <?php 
                                    $ForCat=mysql_query("SELECT img_left, id FROM categories");
                                    while ($RowCat=mysql_fetch_array($ForCat)) {
                                        $link="img/categ/".$RowCat['img_left'];
                                        $href="tea.php?cat=".$RowCat['id'];
                                        print "<a href='$href' border=0><img class=\"imgCat\" src=\"$link\"><a><br>";	
                                    }
                                ?>
                            </div>
                            <img class="imgDown" name="imgDown" src="img/buttonDown.png"  onmouseover="scroll_down('rightScr'), imgOn('imgDown')" onmouseout="scroll_stop('rightScr'),  imgOff('imgDown')" />
            			</div>
                    </td>
                  </tr>
                </table>
			
                
    </td>
  </tr>
  <tr>
		<?php include('blocks/footer.php'); ?>
  </tr>
</table>


 
</body>
</html>
