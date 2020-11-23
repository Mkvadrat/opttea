<?php
	error_reporting(0);
	include ("../blocks/db.php"); /*Соединение с базой*/

	
	$foto = trim($_POST['id']);
	$name = trim($_POST['name']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Добро пожаловать</title>
<link href="css/mn.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/mn.js"></script>
<style>
	.fotoTab {
		width:900px;
		background-color:#666666;
		margin-top:20px;
		}
		
	.fotoTab td {
		background-color:#EBEBEB;
		text-align:center;
		color:#000033;
		font-weight:600;
		}
		
	.inp {
		width:250px;
		}
		
	.nemaDoc {
		margin-top:90px;
		color:#006666;
		font-size:18px;
		font-weight:600;
		font-family:Arial, Helvetica, sans-serif;
		text-align:center;
		}
</style>
</head>
<body onload="floatMenu()">
<table class="inside" border="0">
      <tr>
        <?php include("blocks/LeftTd.php");?>
        <td class="work">
        <?php
                    	$query = mysql_query("  DELETE FROM `doc` WHERE `id`='$foto'");
								
								if ($query == "true") {
									echo '<br/><p class="nemaDoc">Документ  успешно удален</p>.';
									unlink("../img/doc_foto/".$name);	
									unlink("../img/doc_rar/".$name);
								} else {
									echo "Произошла ошибка при изменении информации в базе данных. Повторите попытку еще раз и в случае неудачи обратитесь к администратору";
								}

			?>
                        <p align="center" ><a class="nemaDoc" href="documents.php">вернуться назад</a></p>
       </td>
      </tr>
    </table>
<?php include("blocks/logo.php");?>


  
</body>
</html>