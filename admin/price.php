<?php  include ("login/lock.php");  
	if ($_POST['beensub']) {
		$userfile=$_FILES['userfile'];
		$uploaddir = "../";
		$temp=$_FILES['userfile']['name'];
		$uploadfile = $uploaddir . 'price_TeaCrimea.doc';
		
		if ($temp) {
			copy($_FILES['userfile']['tmp_name'], $uploadfile);
		}
		
		
		$temp=$_FILES['userfile2']['name'];
		$uploadfile2 = $uploaddir . 'price_TeaCrimea_ru.doc';
		
		if ($temp) {
			copy($_FILES['userfile2']['tmp_name'], $uploadfile2);
		}
		
		header('location:price.php');
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
    <td height="500" class="td2">
    
    	<?
    	echo('<div style="text-align:center">');
			  ?>
       		 <form enctype="multipart/form-data" action="" method="post">
             	<table align="center" style="background:#fff; border-collapse:collapse;" cellpadding="3" cellspacing="0" border="1">
                	
                    <tr>
                    	<td>ГРН</td>
                        <td>РУБ</td>
                    </tr>
                    <tr>
                    	<td><input type="file" size="39" name="userfile"></td>
                        <td><input type="file" size="39" name="userfile2"></td>
                    </tr>
                    <tr>
                    	<td align="center" colspan="2"><input type="submit" value="сохранить документы" /></td>
                    </tr>
                </table>
				<input type="hidden" name="beensub" value="ok" >
                        
            </form>
            
        </div>
    </td>
  </tr>
</table>


  
</body>
</html>
