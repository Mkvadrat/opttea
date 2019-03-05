<?php  include ("login/lock.php"); 


$id_cat = $_GET['cat'];
if (isset($_GET['del'])) {
	$idD = $_GET['del'];
	mysql_query("DELETE FROM `Tovari` WHERE `id` = '$idD' ");
}

	if(isset($_POST['name'])){
		$queryLast=mysql_query("  SELECT * FROM `Tovari` where `idCat` = '$id_cat'  ORDER BY `ord1`  DESC  LIMIT 1 ");
		$rowLast=mysql_fetch_array($queryLast);
		$ord = ($rowLast['ord1'] + 1);
	
		$name = $_POST['name'];
		mysql_query( " 
		 INSERT INTO `Tovari` ( `id` , `idCat` , `title` , `description` , `text` , `massa` , `img` , `priceOpt` , `priceMelk` , `priceRoznica` , `meta_d` , `meta_k` , `Sostav` , `Naznachenie` , `ord1` ) 
			VALUES ('', '$id_cat', '$name', '', '', '', '', '', '', '', '', '', '', '', '$ord' );  
			");
	}


/*Сортировка НАЧАЛО*/
	$table = 'Tovari';
	include('blocks/sort2.php');
/*	СОРТИРОВКА КОНЕЦ*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Административная панель</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/style2.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/script.js"></script>

<script>
	$(function(){
		$('.del').click(function(e){
			if(confirm('УДАЛИТЬ?')){
				var id = $(this).data('id');
				var cat = $(this).data('cat');
				top.location = 'tovary.php?cat='+cat+'&del='+id;
			}
		});
		
		$("#sort").sortable({
				stop: function( event, ui ) {
				
				var arr = [];
				$('#sort .tovary-tov').each(function(index, element) {
					var id = $(this).data('id');
					arr[index] = id;
				});
				
				console.log(arr);
				save();
				$.post('ajax-sort.php', {table:'Tovari', 'id[]':arr, ord:'ord1'}, function(data){
					saved();
				});
			}
		});
	
	});
</script>

<style>
	.tovary-tov {float:left; margin:20px; background:#fff; padding:20px; width:200px; height:300px; }
	.tovary-tov img {max-height:300px; max-width:200px;}
	.cl {clear:both;}
	.null-place {color:#d9d9d9;}
	.titleA {font-size:14px; display:block; margin-bottom:10px;}
	.del {margin-top:10px; color:#d9d9d9; cursor:pointer; position:absolute; right:5px; top:0px; font-family:arial;}
	.del:hover {color:red;}
	.tovary-tov {position:relative;}
	
</style>
</head>
<body>
<div id="saved">сохранено</div>

<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td height="500" class="td2">
    	<div id="sort">
    	<?
		$querySlide=mysql_query("SELECT * FROM `Tovari` where `idCat` = '$id_cat'   ORDER BY `ord1` ASC");
		 if(mysql_num_rows($querySlide)>0 ){
			$k = 1;
			while($rowSlide=mysql_fetch_array($querySlide)) {  
				//
				
				$name = $rowSlide['title'];
				$img = '<img src="../img/tovar/'.$rowSlide['img'].'">';
				
				if($name == '' and $rowSlide['img'] == ''){
					$name = '<span class="null-place">пустое место</span>';
					$img = '';
				}
				
				echo('
					<div data-id="'.$rowSlide['id'].'" class="tovary-tov">
						<a class="titleA" href="tovar.php?tov='.$rowSlide['id'].'&cat='.$id_cat.'">  '.$name.'  </a>
						'.$img.'
						<div data-id="'.$rowSlide['id'].'" data-cat="'.$id_cat.'" class="del">X</div>
					</div>
					');

			}
			echo('<br class="cl">');
		}
		?>
        </div>
        <hr /><br />
        <form enctype="multipart/form-data" action="" method="post">
        	<input type="hidden" name="foto" value="1" />
            <input type="hidden" name="cat" value="<? echo $id_cat ?>" />
        	<table  id="catTable" align="center"  border="0" cellspacing="0" cellpadding="0">
            	<tr class="trHead">
                <td>Название товара</td>
                <td>Действие</td>
              </tr>
              <tr>
                <td><input type="text" name="name" size="50" /></td>
                <td><input type="submit" value="добавить" /></td>
              </tr>
            </table>

        </form>
    </td>
  </tr>
</table>


  
</body>
</html>
