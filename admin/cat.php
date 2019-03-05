<?php  include ("login/lock.php");  

if (isset($_GET['del'])) {
	$idD = $_GET['del'];
	mysql_query("DELETE FROM `categories` WHERE `id` = '$idD' ");
	
	header('location:cat.php');
}

if (isset($_POST['save_name'])) {
	$id = $_POST['id'];
	$val = $_POST['val'];
	$val = iconv( 'UTF-8', 'windows-1251',  $val);
	
	mysql_query("Update  `categories` set `nam_categories` = '$val' WHERE `id` = '$id' ") or die(mysql_error());
	
	exit();
}

	if(isset($_POST['name'])){
		$queryLast=mysql_query("  SELECT * FROM `categories` ORDER BY `ord`  DESC  LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$ord = ($rowLast['ord'] + 1);
	
		$name = $_POST['name'];
		mysql_query( " INSERT INTO `categories` ( `id` , `nam_categories` , `description` , `img` , `img_left` , `ord` ) VALUES ('', '$name', '', '', '', '$ord');   "   );
		
		$idFoto = mysql_insert_id();
	}


if ($_POST['foto']) {

	$userfile=$_FILES['foto1'];
	$uploaddir ="../img/catalog/";
	$temp=$_FILES['foto1']['name'];
	$uploadfile = $uploaddir . $temp;

	if ($temp) {
		if(copy($_FILES['foto1']['tmp_name'], $uploadfile)) {
			$foto_sql = $_FILES["foto1"]["name"];
			$query = mysql_query(" UPDATE `categories` SET `img` = '$foto_sql'  WHERE `id` ='$idFoto'  ");
		} else {
			  echo("Ошибка загрузки файла");
		}
		$mes = "<h3> Информация успешно добавлена </h3> ";
	}
}

if ($_POST['foto']) {

	$userfile=$_FILES['foto2'];
	$uploaddir ="../img/categ/";
	$temp=$_FILES['foto2']['name'];
	$uploadfile = $uploaddir . $temp;

	if ($temp) {
		if(copy($_FILES['foto2']['tmp_name'], $uploadfile)) {
			$foto_sql = $_FILES["foto2"]["name"];
			$query = mysql_query(" UPDATE `categories` SET `img_left` = '$foto_sql'  WHERE `id` ='$idFoto'  ");
		} else {
			  echo("Ошибка загрузки файла");
		}
		$mes = "<h3> Информация успешно добавлена </h3> ";
	}
}


/*Сортировка НАЧАЛО*/
	$table = 'categories';
	include('blocks/sort.php');
/*	СОРТИРОВКА КОНЕЦ*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/script.js"></script>

<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />

<script>
	$(function(){
		$('.del').click(function(e){
			if(confirm('УДАЛИТЬ?')){
				var id = $(this).data('id');
				top.location = 'cat.php?del='+id;
			}
		});
		
		$("#sort").sortable({
				stop: function( event, ui ) {
				
				var arr = [];
				$('#sort .tr').each(function(index, element) {
					var id = $(this).data('id');
					arr[index] = id;
				});
				
				
				save();
				$.post('ajax-sort.php', {table:'categories', 'id[]':arr, ord:'ord'}, function(data){
					saved();	
				});
			}
		});
		
		$('.cat-name span').click(function(){
			var id = $(this).parent().data('id');
			var val = $(this).parent().find('input').val();
			
			save();
			$.post('cat.php', {id:id, val:val, save_name:1}, function(data){
				console.log(data);
				saved();	
			});
		});
		
		$('.cat-img1').click(function(){
			var id = $(this).parent().data('id');
			$('#img1-id').val(id);
			$('#ava_file1').click();
		});
		
		$('.cat-img2').click(function(){
			var id = $(this).parent().data('id');
			$('#img2-id').val(id);
			$('#ava_file2').click();
		});
		
		$('#ava_file1').change(function(){
			if($('#ava_file1').val() != ''){
				$('#img1-form').submit();
				//$('#edit-text').show().html('<img src="/img/load.gif" />');
			}
		});
		
		$('#ava_file2').change(function(){
			if($('#ava_file2').val() != ''){
				$('#img2-form').submit();
				//$('#edit-text').show().html('<img src="/img/load.gif" />');
			}
		});

	
	});
	
	function recivedAva1(err, src, id){
		$('.tr[data-id='+id+'] .cat-img1').html('<img src="/img/catalog/'+src+'" /> ');
		$('#ava_file1').val('');
	}
	
	function recivedAva2(err, src, id){
		$('.tr[data-id='+id+'] .cat-img2').html('<img src="/img/catalog/'+src+'" /> ');
		$('#ava_file2').val('');
	}

</script>

<style>
	.col1, .col2, .col3 {float:left;}
	.cl {clear:both;}
	.col1 {width:300px;}
	.col2 {width:300px;}
	.col3 {width:30px;}
	.col4 {width:100px; float:right; cursor:pointer;}
	.tr {background:#fff; margin:15px; box-shadow:0px 0px #ccc; padding:20px; height:150px;}
	.col1 img, .col2 img {max-width:300px; max-height:150px;}
	.del {color:#d9d9d9; cursor:pointer;}
	.del:hover {color:red;}
	.cat-name {margin-top:10px;}
	.cat-name span {color:#06C; border-bottom:1px dotted; cursor:pointer;}
</style>
</head>
<body>
<div id="saved">сохранено</div>

<form id="img1-form" style="position:absolute; visibility:hidden;" action="act_img1.php" target="ava_frame" enctype="multipart/form-data" method="post">
    <input name="Filedata" type="file" id="ava_file1" />
    <input id="img1-id" name="id" type="hidden" value=""  />
    <iframe name="ava_frame" id="upload_image_iframe1"></iframe>
</form>

<form id="img2-form" style="position:absolute; visibility:hidden;" action="act_img2.php" target="ava_frame" enctype="multipart/form-data" method="post">
    <input name="Filedata" type="file" id="ava_file2" />
    <input id="img2-id" name="id" type="hidden" value=""  />
    <iframe name="ava_frame" id="upload_image_iframe2"></iframe>
</form>


<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td height="500" class="td2">
    	<?
		$querySlide=mysql_query("SELECT * FROM `categories`  ORDER BY `ord` ASC");
		 if(mysql_num_rows($querySlide)>0 ){
				/*echo('
					<div class="trH">
						<div class="col1">Фото категории</div>
						<div class="col1">Фото правой панели</div>
						<div class="col2">Название категории</div>
						<div class="col3"></div>
						<br class="cl">
					</div>
					');*/
			echo('<div id="sort">');
				while($rowSlide=mysql_fetch_array($querySlide)) {   
					
						$edit = '
								<div data-id="'.$rowSlide['id'].'" class="cat-name">
									<input  type="text" value="'.$rowSlide['nam_categories'].'"><br>
									<span>сохранить</span>
								</div>
								';
								
						if($rowSlide['id'] == 26) $edit = '';
						
						if($rowSlide['img'] <> ''){
							$img1 = '<img src="../img/catalog/'.$rowSlide['img'].'">';
						}else{
							$img1 = '<span>загрузить фото</span>';
						}
						
						if($rowSlide['img_left'] <> ''){
							$img2 = '<img src="../img/catalog/'.$rowSlide['img_left'].'">';
						}else{
							$img2 = '<span>загрузить фото</span>';
						}
				     
						echo('
							<div data-id="'.$rowSlide['id'].'" class="tr">
								<div class="col1 cat-img1">'.$img1.'</div>
								<div class="col1 cat-img2">'.$img2.'</div>
								<div class="col2">
									<a class="titleA" href="tovary.php?cat='.$rowSlide['id'].'"> ОТКРЫТЬ </a>
									'.$edit.'
								</div>
								<div class="col3"><span data-id="'.$rowSlide['id'].'" class="del">удалить</span></div>
								<div class="col4"><img title="Перетащить вверх или вниз для сортировки" src="/img/drag.png" /></div>
								<br class="cl">
							</div>
							');
				}
			echo('</div>');

		}
		?>
        <hr /><br />
        <form enctype="multipart/form-data" action="" method="post">
        	<input type="hidden" name="foto" value="1" />
        	<table  id="catTable" align="center"  border="0" cellspacing="0" cellpadding="0">
            	<tr class="trHead">
                <td>Фото категории</td>
                <td>Фото правой панели</td>
                <td>Название категории</td>
                <td>Действие</td>
              </tr>
              <tr>
                <td ><input type="file" size="10" name="foto1" /></td>
                <td><input type="file" size="10" name="foto2" /></td>
                <td><input type="text" name="name" size="30" /></td>
                <td><input type="submit" value="добавить" /></td>
              </tr>
            </table>

        </form>
        <br /><br /><br />
    </td>
  </tr>
</table>


  
</body>
</html>
