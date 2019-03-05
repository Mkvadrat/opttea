<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
		$row = mysql_fetch_array($rezult);
	}
	
	$id=$_GET['cat'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<!--[if IE]> <link href="css/ie.css" rel="stylesheet" type="text/css" /> <![endif]-->
<link href="css/tip.css" rel="stylesheet" type="text/css" />

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
	
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script>
		$(function(){
			$('.popup').mousemove(function(e){
				var x = e.pageX;
				var y = e.pageY+25;
			
				var text = $(this).data('popup');
				$('.popup-frame').html(text);
				
				$('.popup-frame').css({'top':y, 'left':x}).show();
			}).mouseleave(function(){
				$('.popup-frame').hide();
			});
		});
</script>

<style>
	.popup-frame {display: none; font-family:Verdana, Geneva, sans-serif; font-size: 13px; line-height: 1.3; box-shadow: 1px 1px 1px 1px #ccc; color: #777; position: absolute; left: 50%; z-index: 100; width: 200px; padding: 15px; background: #fff; border-radius: 3px; border: 1px solid #f5f5f5;}
	.popup-frame h3 {margin: 0px 0px 5px 0px; font-size: 14px;}
</style>
</head>

<body>
	<div id="cat-popup" class="popup-frame"></div>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="cenTd">
    			<?
    			    
    			?>
                <table width="100%" border="0"  cellspacing="0" cellpadding="5">
                  <tr>
                   <?php include('blocks/left.php'); ?>
                   <td valign="top" class="center" >

                        	 <?php 
		 	$ForInf=mysql_query("SELECT  title, description FROM Tovari WHERE idCat='$id'
															ORDER BY `Tovari`.`ord1` ASC ") or die(mysql_error());
			$count=mysql_num_rows($ForInf);
			if ($count==0) {
				print "
					<td width=80% align='center'><strong>Изваените, категория доробатывается!</strong></td>
        			</tr>
    				</table></td>
  					</tr>"
					;
				include ("blocks/footer.php");
				print"
					</table>
					</body>
					</html>
				";
				exit();
			}
			$n=1;
			print"<td valign=\"top\"  class=\"teaTd\" >";
			while ($Rowinf=mysql_fetch_array($ForInf)) {
				$title=$Rowinf['title'];
				$description=$Rowinf['description'];
				if (count($n)==1){
					$number="tea0".$n;
				} else {
					$number="tea".$n;
				}
				
				$n++;
			}
			
			$polka=1;
			$kvo=1;
			$napolke=0;
			$n=1;
			
			if($id == 44){
		        $soap = ('<a style="text-decoration:none; text-transform:uppercase" href="http://tea-crimea.ru/doc/soap.pps" target="_blank">Посмотреть презентацию</a>');
		    }
			print"
				<div class=\"teaBcase\"> <div >
				$soap
				<table height=\"100\" width=\"900\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr align=\"center\">
			";
			$ForInf=mysql_query("SELECT  `id`, `img`, `title`, `text`, `description` FROM Tovari WHERE idCat='$id'  ORDER BY `Tovari`.`ord1` ASC ");
			
			while ($Rowinf=mysql_fetch_array($ForInf)) {
				
				$id=$Rowinf['id'];
				$linkcategor="goods.php?tovar=".$id;
				if($Rowinf['img'] == ''){
					$img="img/tovar/point.png";
				}else{
					$img="img/tovar/".$Rowinf['img'];
				}
				
				if (count($n)==1){
					$number="tea0".$n;
				} else {
					$number="tea".$n;
				}
				
				//$text = substr($Rowinf['description'], 0, 300).'...';
				$text = strip_tags($Rowinf['description']);
				$text = str_replace('"', '', $text);
				$title = str_replace('"', '',$Rowinf['title']);
				$data = 'class="popup" data-popup="<h3>'.$title.'</h3> '.$text.'"';
				
				if($kvo==4 ){
					$napolke=0;
					 if($count==$n){
						 echo('<td width="180" valign="bottom" > <a '.$data.' href="'.$linkcategor.'"> <img src="'.$img.'" /></a> </td>');
					 }else{
						echo('<td width="180" valign="bottom" > <a '.$data.' href="'.$linkcategor.'"><img  src="'.$img.'" /></a></td>');
						print"
						</tr>
                		</table>
 						</div></div>
						<div class=\"teaBcase\"> <div >
						<table height=\"100\" width=\"900\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                		<tr align=\"center\">
						";
					 }
					 if ($polka==3) {
							$polka=0;
				}
					$polka++;
					$kvo=0;
				} else {
					if($napolke==2){
						$linkpolka="img/flower".$polka.".png";
						//print "<td width=\"180\" valign=\"bottom\" ><!--<img alt=\"\"  src=\"$linkpolka\" />--></td>";
						$napolke=0;
					} 
					$napolke++;
					echo('<td width="180" valign="bottom" > <a '.$data.' href="'.$linkcategor.'"><img  src="'.$img.'" /> </a>  </td>');
				}
				$n++;
				$kvo++;
					
				
			}
					if($kvo==2){
						print "<td width=\"180\" valign=\"bottom\" > </td>";
						$linkpolka="img/flower".$polka.".png";
						//print "<td width=\"180\" valign=\"bottom\" ><!--<img alt=\"\"  src=\"$linkpolka\" />--></td>";
						print "<td width=\"180\" valign=\"bottom\" > </td>";
						print "<td width=\"180\" valign=\"bottom\" > </td>";
					} 
					if($napolke==2){
						$linkpolka="img/flower".$polka.".png";
						//print "<td width=\"180\" valign=\"bottom\" ><!--<img alt=\"\"  src=\"$linkpolka\" />--></td>";
						
					} 
					if($kvo==3){
						
						print "<td width=\"180\" valign=\"bottom\" > </td>";
						$kvo++;
					} 
					if($kvo==4){
						
						print "<td width=\"180\" valign=\"bottom\" > </td>";
						$kvo++;
					} 
		 
		 ?>
       	
         </tr>
    </table>
</div></div>       
              
                   </td>
                </tr>
                </table>
    </td>
  </tr>
  <tr>
	<?php include('blocks/footer.php'); ?>
  </tr>
</table>

<?php include('blocks/end.php'); ?>
</body>
</html>
