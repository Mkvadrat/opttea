<?php  	include ("login/lock.php");  

	$err = 0;
	$id = $_POST['id'];
	
	/*$id = $_POST['id'];
	$queryManager = mysql_query(" Select `img` From `city` where `id` = '$id' ");
	$rowUser = mysql_fetch_array($queryManager);
	$city_img = $rowUser['img'];
	if($city_img <> ''){
		unlink($_SERVER['DOCUMENT_ROOT'].'/region/'.$city_img);
	}*/

	$arr = array('z', 'x', 'c', 'v', 'b', 'n', 'm', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'k', 'l', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',  '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	$num1 = rand(0,36);
	$num2 = rand(0,36);
	$num3 = rand(0,36);
	$num4 = rand(0,36);
	$num5 = rand(0,36);
	$num6 = rand(0,36);
	
	$randName = $id.'_'.$arr[$num1].$arr[$num2].$arr[$num3].$arr[$num4].$arr[$num5].$arr[$num6];
	


	$filename = $randName;
	
	
	$fileName = $_FILES['Filedata']['name'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	preg_match('`\.(gif|png|jpe?g)`i',$fileName, $match);
	$PhotoFormat = strtolower($match[0]);
	$fileName = preg_replace('`\.(gif|png|jpe?g)`i','',$fileName);
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	$randName .=$PhotoFormat;
	$targetFile = rtrim($targetPath,'/') . '/img/catalog/' . $randName;
	
	$fileTypes = array('jpg','JPG','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		
		mysql_query(" Update `categories` set `img` = '$randName' where `id` = '$id' ");
		
		/*$size=GetImageSize ($targetFile);
		$src=ImageCreateFromJPEG ($targetFile);
		$iw=$size[0];
		$ih=$size[1];
		$koe=$iw/800;
		$new_h=ceil ($ih/$koe);
		$dst=ImageCreateTrueColor (800, $new_h);
		ImageCopyResampled ($dst, $src, 0, 0, 0, 0, 800, $new_h, $iw, $ih);
		ImageJPEG ($dst, $targetFile, 100);
		imagedestroy($src);*/
	}else{
		$err = 1;	
	}
		
	echo('<script>this.parent.recivedAva1('.$err.', "'.$randName.'", '.$id.');</script>'); 

?>