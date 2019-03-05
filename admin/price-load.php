<?php  include ("login/lock.php");  

	function get_format($name){
		$name_split = explode('.', $name);
		return array_pop($name_split);
	}
	
	function del_files($dir){
		$op_dir=opendir($dir);
		while($file=readdir($op_dir )){
			if($file != "." && $file != ".."){
				unlink ($dir.$file);
			}
		}
		//closedir($dir);
	}

	if ($_POST['beensub']) {
		$type = $_POST['type'];
		
		$format = get_format($_FILES['userfile']['name']);
		$uploaddir = '../doc/'.$type.'/';
		$upload_file = $uploaddir.$type.'.'.$format;
		
		del_files($uploaddir);
		
		if(copy($_FILES['userfile']['tmp_name'], $upload_file)) {
			$err = "Успешно загружен";
		}else {
			$err = "Ошибка загрузки";
		}
	}
	
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Загрузить прайсы</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script>
	var result = '<?=$err?>';
	if(result != '') alert(result);
</script>
<style>
	.doc-column {width:50%; float:left;}
</style>
</head>
<body>
<table id="mainTab" align="center" width="1200" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="td2" align="center">
        <div class="doc-column doc1">
        	<h3 align="center">Загрузить прайс РУБ</h3>
             <form action="" method="post" enctype='multipart/form-data'>
                <input class="inp" type="file" name="userfile" >
                <input type = "hidden" value = "true" name = "beensub">
                <input type = "hidden" value = "rub" name = "type">
                <input type="submit" value="загрузить">
             </form>
        </div>
        <div class="doc-column doc2">
        	<h3 align="center">Загрузить прайс ГРН</h3>
        	<form action="" method="post" enctype='multipart/form-data'>
                <input class="inp" type="file" name="userfile" >
                <input type = "hidden" value = "true" name = "beensub">
                <input type = "hidden" value = "grn" name = "type">
                <input type="submit" value="загрузить">
             </form>
        </div>
        <br style="clear:both" />

       
    </td>
  </tr>
</table>


  
</body>
</html>
