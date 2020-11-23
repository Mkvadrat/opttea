<?php  include ("login/lock.php");  

if(isset($_POST['t1'])){
	$text = mysql_real_escape_string($_POST['text']);
	$id = 1;
	
	mysql_query(" Update `counts` set `text` = '$text' where `id` = '$id' ");
	header('location:counts.php');
}

if(isset($_POST['t2'])){
	$text = mysql_real_escape_string($_POST['text']);
	$id = 2;
	
	mysql_query(" Update `counts` set `text` = '$text' where `id` = '$id' ") or die(mysql_error());
	header('location:counts.php');
}

if(isset($_POST['t3'])){
	$text = mysql_real_escape_string($_POST['text']);
	$id = 3;
	
	mysql_query(" Update `counts` set `text` = '$text' where `id` = '$id' ");
	header('location:counts.php');
}

if(isset($_POST['t4'])){
	$text = mysql_real_escape_string($_POST['text']);
	$id = 4;
	
	mysql_query(" Update `counts` set `text` = '$text' where `id` = '$id' ");
	header('location:counts.php');
}


$queryTehn=mysql_query("SELECT * FROM `counts` order by `id` ");
if(mysql_num_rows($queryTehn)>0 ){
	while($RowTehnLang=mysql_fetch_array($queryTehn)){
		$id = $RowTehnLang['id'];
		$text[$id] = $RowTehnLang['text'];
	}
}
        
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<style>
	body {font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;}
</style>

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
    <td align="center" valign="top" height="500" class="td2">
    <h3>Счет для России (физ)</h3>
    <form action="" enctype="application/x-www-form-urlencoded" method="post">         
        <textarea name="text" id="text2" cols="50" rows="10"><?=$text[2]?></textarea> 
        <script type="text/javascript"> 
            var oFCKeditor = new FCKeditor("text2"); // привязываем к textarea с id="text" 
            oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
            oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
            oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
        </script>		
        <br /><br />
        <input type="hidden" value="2" name="t2" />
        <input type="submit" value="сохранить" />
        <br />
    </form>
    <br /><br />
    <h3>Счет для Украины (физ)</h3>
    <form action="" enctype="application/x-www-form-urlencoded" method="post">         
        <textarea name="text" id="text" cols="50" rows="10"><?=$text[1]?></textarea> 
        <script type="text/javascript"> 
			var oFCKeditor = new FCKeditor("text"); // привязываем к textarea с id="text" 
			oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
			oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
			oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
        </script>		
        <br /><br />
        <input type="hidden" value="1" name="t1" />
        <input type="submit" value="сохранить" />
        <br />
    </form>
	<br /><br />
    
    <h3>Счет для Украины (юр)</h3>
    <form action="" enctype="application/x-www-form-urlencoded" method="post">         
        <textarea name="text" id="text3" cols="50" rows="10"><?=$text[3]?></textarea> 
        <script type="text/javascript"> 
            var oFCKeditor = new FCKeditor("text3"); // привязываем к textarea с id="text" 
            oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
            oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
            oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
        </script>		
        <br /><br />
        <input type="hidden" value="3" name="t3" />
        <input type="submit" value="сохранить" />
        <br />
    </form>
    <br /><br />
    <h3>Счет для России(юр) </h3>
    <form action="" enctype="application/x-www-form-urlencoded" method="post">         
        <textarea name="text" id="text4" cols="50" rows="10"><?=$text[4]?></textarea> 
        <script type="text/javascript"> 
			var oFCKeditor = new FCKeditor("text4"); // привязываем к textarea с id="text" 
			oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
			oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
			oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
        </script>		
        <br /><br />
        <input type="hidden" value="4" name="t4" />
        <input type="submit" value="сохранить" />
        <br />
    </form>
	<br />
    
    </td>
  </tr>
</table>


  
</body>
</html>
