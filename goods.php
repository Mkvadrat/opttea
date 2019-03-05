<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
		$row = mysql_fetch_array($rezult);
	}
	$id=$_GET['tovar'];
	
	$rezult = mysql_query ("SELECT * FROM Tovari WHERE id='$id'",$db);
	
	if (!$rezult) {
		
		exit(mysql_error());
	} else {
		if (mysql_num_rows($rezult)>0){
			$row = mysql_fetch_array($rezult);
		}else{
			print"В таблице нет записей";
			exit();
		}
	}
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

<link href="css/stFrame.css" rel="stylesheet" type="text/css" />
<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />
<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
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
                   <td valign="top" class="center" >

                        		        <?php 
			$link="img/tovar/".$row['img'];
		?>
       <div class="logo"> 

            <span class="b1"></span><span class="b2"></span><span class="b3"></span><span class="b4"></span>
			<div class="content">
					<img src="<?php echo $link; ?>" ></center>
			</div>
			<span class="b4"></span><span class="b3"></span><span class="b2"></span><span class="b1"></span>

       </div>
       <span class="goodsName"> <?php echo $row['title']; ?></span>
        <div class="goodsPrice"> Цена: <span>  <?php echo $row['priceRoznica']; ?>.00 грн</span></div>
        <div class="goodsPrice"> Цена: <span> <?=$row['cost_roz_ru']?>.00 руб</span></div>
       <div class="goodsPrice"> Вес товара: <span>  <?php echo $row['massa']; ?>  гр.</span></div>
       
       <div class="goodsText"> 
       
       <?php 
	   		
	   		echo $row['text']; 
	   ?>
       
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

<?php include('blocks/end.php'); ?>
 
</body>
</html>
