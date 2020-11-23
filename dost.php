<?php  include ("login/lock.php");  ?>

<?
	if (isset($_POST['text'])) {
		$text = $_POST['text'];
		mysql_query("UPDATE `set_table_sist` SET `text` = '$text'  WHERE `page` = 'delivery' ");
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td align="center" height="500" class="td2">
    	
        
		 <form action="" enctype="application/x-www-form-urlencoded" method="post">         
						  <textarea name="text" id="text" cols="50" rows="10">
									 <?php
								  $queryTehn=mysql_query("SELECT * FROM `set_table_sist` where `page` = 'delivery' ");
								if(mysql_num_rows($queryTehn)>0 ){
										$RowTehnLang=mysql_fetch_array($queryTehn);
										$text = $RowTehnLang['text'];
										$id = $RowTehnLang['id'];
										echo($text);
									}
									?>
						  </textarea> 
					<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
                    <script type="text/javascript"> 
                            var oFCKeditor = new FCKeditor("text"); // привязываем к textarea с id="text" 
                            oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
                            oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
                            oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
                    </script>		
                    <br /><br />
                <input type="submit" value="сохранить" />
                <br />
           </form>
		
    </td>
  </tr>
</table>


  
</body>
</html>
