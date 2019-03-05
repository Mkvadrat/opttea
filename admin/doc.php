<?php  include ("login/lock.php");  ?>

<?
								If(isset($_POST['delete'])){
										$fotoD = $_POST['id'];
										$nameD = $_POST['name'];
										$rar = $_POST['rar'];
										
										$queryDel = mysql_query("  DELETE FROM `doc` WHERE `id`='$fotoD'");
										
										if ($queryDel == "true") {
											unlink("../img/doc_foto/".$nameD);	
											unlink("../img/doc_rar/".$rar);
										} else {
											echo "Произошла ошибка при изменении информации в базе данных. Повторите попытку еще раз и в случае неудачи обратитесь к администратору";
										}
								}

	if ($_POST['beensub']) {
	
		$userfile=$_FILES['userfile'];
		$uploaddir = "../img/doc_foto/";
		$temp=$_FILES['userfile']['name'];
		$uploadfile = $uploaddir . $temp;
		
		$userfile_rar=$_FILES['userfile_rar'];
		$uploaddir_rar = "../img/doc_rar/";
		$temp_rar=$_FILES['userfile_rar']['name'];
		$uploadfile_rar = $uploaddir_rar . $temp_rar;
		$foto_sql = $_FILES["userfile"]["name"];
		$foto111 = $_POST['foto111'];
		
		if ($temp_rar) {
			if(move_uploaded_file($_FILES['userfile_rar']['tmp_name'], $uploadfile_rar) and move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				$ok9 = ("<p align='center' class='true_foto'>Изображение успешно загружено.<p>");
				$foto_rar = $_FILES["userfile_rar"]["name"];
				$query = mysql_query("  INSERT INTO `doc` ( `id` , `foto` , `rar` , `desc` )  VALUES ( '', '$foto_sql', '$foto_rar', '$foto111' );   ");
								
								if ($query == "true") {
									$kr =  "<p align='center'>Изменения успешно добавлены в базу данных.</p>";				
								} else {
									echo "Произошла ошибка при изменении информации в базе данных. Повторите попытку еще раз и в случае неудачи обратитесь к администратору";
								}
			} else {
				  echo("Ошибка загрузки файла");
			}
		}
	}
	$query = mysql_query ("SELECT * FROM doc");
	
	if (mysql_num_rows($query)>0){
			$row = mysql_fetch_array($query);
			}
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
	.fotoTab {
		width:900px;
		background-color:#666666;
		margin-top:20px;
		}
		
	.fotoTab td {
		background-color:#ffffff;;
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
</style>
</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td height="500" class="td2" align="center">
        <div style="margin-top:10px;" class="nemaDoc">Добавить документ</div>
        	<table class="fotoTab" width="100%" border="1" cellspacing="5" cellpadding="5">
                  <tr>
                    <td width="285">Изображение</td>
                    <td width="285">Архив с изоб</td>
                    <td width="160">Название</td>
                    <td>Выполнить</td>
                  </tr>
                </table>
			<form action="" method="post" enctype='multipart/form-data'>
                <table class="fotoTab" width="100%" border="1" cellspacing="5" cellpadding="5">
                  <tr>
                    <td><input class="inp" type="file" name="userfile" ></td>
                    <td><input class="inp" type="file" name="userfile_rar" ></td>
                    <td><input type="text" name="foto111"></td>
                    <td><input type="submit" value="Добавить">
					<input type = "hidden" value = "true" name = "beensub"></td>
                  </tr>
                </table>
             </form>
             
             <div class="nemaDoc">Текущие документы</div>
             
                 <?php
				 if (isset($row)) {
					do{
					$img =  $row["foto"];
					$rar =  $row["rar"];
					$dsc = $row['desc'];
					$id = $row['id'];
					echo '
							 <form action="" name="foto1" method="post" enctype="multipart/form-data">
								<table class="fotoTab"  border="1" cellspacing="5" cellpadding="5">
								  <tr>
									<td width="100"><img width="100" src="../img/doc_foto/'.$img.' "</td>
									<td width="700">'.$dsc.'</td>
									<td width="100"> 
										<input name="id" type="hidden" value="'.$id.'">
										<input name="name" type="hidden" value="'.$img.'">
										<input type="submit" value="Удалить">
										<input name="rar" type="hidden" value="'.$rar.'">
									</td>
								  </tr>
								</table>
								<input name="delete" type="hidden" value="ok">
							 </form>
						 ';
					}while ( $row = mysql_fetch_array($query));
				}else {
						echo ('<div style="color:#ffffff" class="nemaDoc">В базе данных отсутствуют текущие документы.</div>');
				}
			?>                	
       
    </td>
  </tr>
</table>


  
</body>
</html>
