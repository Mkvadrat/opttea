<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
	$row = mysql_fetch_array($rezult);
}


$nSlide = 0;
$querySlider = mysql_query(" SELECT * FROM  `slider` order by `ord` ");
while($rowSlider = mysql_fetch_array($querySlider)){
	if($nSlide == 0){
		$slideClass = 'class="default"';	
		$slide1 = '<img  src="/img/slider/1/'.$rowSlider['img'].'" />';
	}else{
		$slideClass = '';
	}
	
	$nav_slide[] = $rowSlider['img'];
	
	$imgSlide = '<img data-img="'.$rowSlider['img'].'" '.$slideClass.' src="/img/slider/2/'.$rowSlider['img'].'" />';
	$imgSlids .= $imgSlide;
	
	$nSlide++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />
<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">

<script>
	$(function(){
		$('#slider-nav-right').click(function(){
			var alln = $('.slider-image').data('all');
			var n = $('.slider-image').data('n');
			var images = $('.slider-image').data('img');
			var arr_img = images.split(',');
			
			cur_n = n+1;
			
			if(cur_n >= alln) cur_n = 0;
			
			var cur_img = arr_img[cur_n];
			
			$('.slider-image').html('<img src="/img/slider/1/'+cur_img+'" />');
			$('#slider-nav-center').html((cur_n+1)+' из '+alln);
			$('.slider-image').data('n', cur_n);
			
		});
		
		$('#slider-nav-left').click(function(){
			var alln = $('.slider-image').data('all');
			var n = $('.slider-image').data('n');
			var images = $('.slider-image').data('img');
			var arr_img = images.split(',');
			
			cur_n = n-1;
			
			if(cur_n == -1) cur_n = (alln-1);
			
			var cur_img = arr_img[cur_n];
			
			$('.slider-image').html('<img src="/img/slider/1/'+cur_img+'" />');
			$('#slider-nav-center').html((cur_n+1)+' из '+alln);
			$('.slider-image').data('n', cur_n);
			
		});
	});
</script>

<style>
	.slider-image {width:700px; height:436px; border:4px solid #888; border-radius:4px 4px 0px 0px;}
	#slider_present {width:708px;}
	#slider-nav-left, #slider-nav-right {font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif; font-size:20px; color:#fff; padding:10px 20px; text-transform:uppercase; height:23px; border-radius:0px 0px 4px 4px }
	#slider-nav-left {float:left; width:200px; background:#dedede; cursor:pointer;}
	#slider-nav-left:hover, #slider-nav-right:hover {background:#98ce44;}
	#slider-nav-right {float:right; width:200px;  background:#dedede; cursor:pointer; text-align:right;}
	#slider-nav-center {float:left; padding:7px 20px; background:#777; color:#fff; text-align:center; font-size:20px; font-family:Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif; height:29px; width:188px;}
	
	.unsel{
	  -moz-user-select: none;
	  -khtml-user-select: none;
	  -webkit-user-select: none;
	  -o-user-select: none;
	  user-select: none;
	}
</style>
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="400" class="cenTd">
    			
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <?php include('blocks/left.php'); ?>
                    <td valign="top" class="center">
                    	
                    	<div class="cenText">
                        	<img src="img/logo.png" class="logo" />
                            <?php echo $row['text']; ?>
                            <?
							echo('
								<div id="slider_present" class="barousel">
									<div data-all="'.mysql_num_rows($querySlider).'" data-n="0" data-img="'.implode(',', $nav_slide).'" class="slider-image">
										'.$slide1.'
									</div>
									<div class="barousel_nav">
										<div class="unsel" id="slider-nav-left">&larr; Назад</div>
										<div id="slider-nav-center">1 из 19</div>
										<div class="unsel" id="slider-nav-right">Вперед &rarr;</div>
										<br style="clear:both;" />
									</div>
								</div>
								');
							?>
                        
                            <div style="text-align:center; margin-top:100px; ">
                            	<a href="http://www.park-usadba.ru" target="_blank">  <img  src="img/adv_usadba2.png" /></a>
                                &nbsp;
                                <a href="http://nectar-crimea.ru/" target="_blank"><img height="150"  src="//nectar.crimea.ua/img/logo.png" /></a>
                                    
                                
                            </div>
                         
                         </div>
                         
                         
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
