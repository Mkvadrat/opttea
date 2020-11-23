<?php  include ("login/lock.php");  ?>

<?
	$id = $_GET['tov'];
	$cat = $_GET['cat'];
	
	if(isset($_POST['name'])){
		include ("blocks/transelit.php");  
		
		$name = mysql_real_escape_string($_POST['name']);
		$text = mysql_real_escape_string ($_POST['text']);
		$desc = $_POST['desc'];
		$massa = $_POST['massa'];
		$sost = $_POST['sost'];
		$nazn = $_POST['nazn'];
		$link_product = $_POST['link_product'];
		$pr_melk = $_POST['pr_melk'];
		$pr_opt = $_POST['pr_opt'];
		$pr_roz = $_POST['pr_rozn'];
		
		$cost_opt_ru = $_POST['cost_opt_ru'];
		$cost_roz_ru = $_POST['cost_roz_ru'];
		
		mysql_query( " 
			UPDATE `Tovari` SET `idCat` = '$cat',
			`title` = '$name',
			`description` = '$desc',
			`text` = '$text',
			`massa` = '$massa',
			`priceOpt` = '$pr_opt',
			`priceMelk` = '$pr_melk',
			`priceRoznica` = '$pr_roz',
			`Sostav` = '$sost',
			`Naznachenie` = '$nazn',
			`link_product` = '$link_product',
			`meta_d` = '$description',
			`title` = '$name',
			`cost_opt_ru` = '$cost_opt_ru',
			`cost_roz_ru` = '$cost_roz_ru'
			 WHERE `id` ='$id'
			") or die(mysql_error());
			
		if ($_POST['foto']) {

			$userfile=$_FILES['foto2'];
			$uploaddir ="../img/tovar/";
			$temp= translitIt($_FILES['foto2']['name']);
			$uploadfile = $uploaddir . $temp;
		
			if ($temp) {
				if(copy($_FILES['foto2']['tmp_name'], $uploadfile)) {
					$foto_sql = translitIt($_FILES["foto2"]["name"]);
					$query = mysql_query("  UPDATE `Tovari` SET `img` = '$foto_sql' WHERE `id` ='$id'  ");
				} else {
					  echo("Ошибка загрузки файла");
				}
				$mes = "<h3> Информация успешно добавлена </h3> ";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td height="500" class="td2">
    	<form enctype="multipart/form-data" action="" method="post">
    	<?
			$querySlide=mysql_query("SELECT * FROM `Tovari`  where  `id`= '$id' ");
			$rowSlide=mysql_fetch_array($querySlide);
			$title_name = str_replace('"', '', $rowSlide['title']);
			if(!empty($rowSlide['img'])){
				$path = '../img/tovar/';
				
				$fotos = $path.$rowSlide['img'];
			}else{
				$fotos = '../img/tea/no_image.png';
			}
			echo('
		<table id="tovTable" align="center" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="tov_name"> НАЗВАНИЕ</td>
            <td><input type="text" size="100" name="name" value="'.$title_name.'"></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="tov_name"> ТЕКСТ</td>
            <td><textarea id="text" cols="75" rows="5" name="text">'.$rowSlide['text'].'</textarea></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> ФОТО</td>
            <td align="center">
				<img src="'.$fotos.'"><br>
				<input type="file" name="foto2" size="30">
				<input type="hidden" name="foto" value="1" />
			</td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> ОПИСАНИЕ</td>
            <td><textarea id="text2" cols="75" rows="5" name="desc">'.$rowSlide['description'].'</textarea></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> МАССА</td>
            <td><input type="text" size="100" name="massa" value="'.$rowSlide['massa'].'"></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> СОСТАВ</td>
            <td><textarea cols="75" rows="5" name="sost">'.$rowSlide['Sostav'].'</textarea></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> НАЗНАЧЕНИЕ</td>
            <td><textarea cols="75" rows="5" name="nazn">'.$rowSlide['Naznachenie'].'</textarea></td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td class="tov_name">ССЫЛКА НА САЙТ</td>
			<td><input type="text" size="100" name="link_product" value="'.$rowSlide['link_product'].'"></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> ОПТ [грн]</td>
            <td><input type="text" size="100" name="pr_opt" value="'.$rowSlide['priceOpt'].'"></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> МЕЛКИЙ ОПТ [грн]</td>
            <td><input type="text" size="100" name="pr_melk" value="'.$rowSlide['priceMelk'].'"></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> РОЗНИЦА [грн]</td>
            <td><input type="text" size="100" name="pr_rozn" value="'.$rowSlide['priceRoznica'].'"></td>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td class="tov_name"> ОПТ [руб]</td>
            <td><input type="text" size="100" name="cost_opt_ru" value="'.$rowSlide['cost_opt_ru'].'"></td>
            <td>&nbsp;</td>
          </tr>
           <tr>
            <td class="tov_name"> РОЗНИЦА [руб]</td>
            <td><input type="text" size="100" name="cost_roz_ru" value="'.$rowSlide['cost_roz_ru'].'"></td>
            <td>&nbsp;</td>
          </tr>
		  <input type="hidden" name="cat" value="'.$cat.'">
          <tr>
            <td align="center"  colspan="3"> <input  type="submit" value="сохранить" /></td>
          </tr>
        </table>
		');
        ?>
		<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
            <script type="text/javascript"> 
                    var oFCKeditor = new FCKeditor("text"); // привязываем к textarea с id="text" 
                    oFCKeditor.ToolbarSet="Default"; // число кнопочек на панели (полная Default) 
                    oFCKeditor.BasePath="fckeditor/"; //путь к fckeditor  
                    oFCKeditor.ReplaceTextarea(); // вставка текста из textarea с id="text" 
            </script>		
        </form>
    </td>
  </tr>
</table>


  
</body>
</html>
