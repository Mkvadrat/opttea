<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
		$row = mysql_fetch_array($rezult);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>
<script type="text/javascript" src="js/image_zoom.js"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

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
                               <td valign="top" class="center">
            
                                            <?php
								$rezult2 = mysql_query("Select * From doc order by id ASC",$db);
                                if (mysql_num_rows($rezult2)>0){
                                    $row2 = mysql_fetch_array($rezult2);
                                    do {
                                        $ft = $row2['foto'];
                                        $rar = $row2['rar'];
                                        $dc = $row2['desc'];
                                        echo("
                                        
                                            <table align='center' class='docTab'  border='0' cellspacing='10' cellpadding='8'>
                                              <tr>
                                                <td width='100'><a href='../img/doc_foto/$ft '  onclick='this.href = \"javascript:void(0)\";'> <img width='100' src='img/doc_foto/$ft' border='0' onClick='new ImageExpander(this, \"img/doc_foto/$ft\");'> </a></td>
                                                <td width='300' class='docTd1'>$dc</td>
                                                <td width='100'><a href='img/doc_rar/$rar'><img src='img/download.png' /><br />скачать</a></td>
                                              </tr>
                                             <tr>
                                            </table>
                                        
                                        ");
                                    }while ( $row2 = mysql_fetch_array($rezult2));
                                }else{
                                    echo("<p align='center'>Документы отсутствуют</p>");
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
