<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='pricelist'",$db);
if (mysql_num_rows($rezult)>0){
	$row = mysql_fetch_array($rezult);
}

if(isset($_GET['country'])){
	$country = $_GET['country'];
	$sel_cou[$country] = 'selected="selected"';	
}else{
	$country = 'ru';
	$sel_cou[$country] = 'selected="selected"';
}

if(isset($_GET['type'])){
	$type = (int)$_GET['type'];
	$sel_type[$type] = 'selected="selected"';	
}else{
	$type = 3;
	$sel_type[$type] = 'selected="selected"';
}

if($country == 'ru'){
	$currency = '���';	
}else if($country == 'ua'){
	$currency = '���';	
}

$cost_ru_arr[1] = 'cost_roz_ru';
$cost_ru_arr[2] = 'cost_melk_ru';
$cost_ru_arr[3] = 'cost_opt_ru';
$cost_ru_arr[4] = 'large_cost_ru';
$cost_ru_arr[5] = 'large_cost_ru';

$cost_ua_arr[1] = 'priceRoznica';
$cost_ua_arr[2] = 'priceMelk';
$cost_ua_arr[3] = 'priceOpt';
$cost_ua_arr[4] = 'large_cost_ua';
$cost_ua_arr[5] = 'large_cost_ua';

if($country == 'ru'){
        if($type == 1){
                $limitSum = '2000';
        }else if($type == 2){
                $limitSum = '5000';
        }else if($type == 3){
                $limitSum = '10000';
        }else if($type == 4){
                $limitSum = '200000';
        }else if($type == 5){
                $limitSum = '10000';
        }
	
}else if($country == 'ua'){
	if($type == 1){
		$limitSum = '300';
	}else if($type == 2){
		$limitSum = '1000';
	}else if($type == 3){
		$limitSum = '3000';
	}else if($type == 4){
		$limitSum = '45000';
	}else if($type == 5){
		$limitSum = '3000';
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="js/libs/bootstrap/css/bootstrap.min.css">
<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />

<script src="js/libs/jquery/jquery.min.js"></script>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>
<script type="text/javascript" src="js/basket.js?ver=121"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />

<title><?php echo $row['title']; ?></title>

<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">

<script>
	var currency = '<?=$currency?>';
	var limitSum = '<?=$limitSum?>';
	
	$(function(){
		$('#type-check input').on('change', function(){
			var val = $('#type-check input:checked').val();
			if(val == 0){
				$('.tr-ur').hide();	
			}else{
				$('.tr-ur').show();	
			}
		});
	});
	
	//start maps
	ymaps.ready(init);

	function init () {
		var myMap = new ymaps.Map("map", {
			center: [44.425340, 34.059471],
			zoom: 18,
			<!--������ �������� ����������: controls: []	 -->
			controls: []
		}, {
			searchControlProvider: 'yandex#search'
		});

		if (window.matchMedia("(max-width: 1500px)").matches) {
			myMap.setCenter([44.425340, 34.059471])
		};
		if (window.matchMedia("(max-width: 992px)").matches) {
			myMap.setCenter([44.425340, 34.059471])
		};
		if (window.matchMedia("(max-width: 767px)").matches) {
			myMap.setCenter([44.425340, 34.059471])
		};

		myGeoObject = new ymaps.GeoObject({

		properties: {

			iconContent: 'Lorem',
			hintContent: '�������� "Lorem"'
		}
		}, {
			preset: 'islands#blackStretchyIcon',
			draggable: false,
		});

		myMap.behaviors

		.disable('scrollZoom')

		myMap.geoObjects
			.add(myGeoObject)
			.add(new ymaps.Placemark([44.425340, 34.0594713], {
			iconCaption: '������ ��������'
		}, {
			preset: 'islands#greenDotIconWithCaption'
		}))
	}
	//end maps
	$(document).ready(function() {
		//js theme functions
		var items = 6; // - ���������� ������������ ��������
		hideitems = "������ ���������";
		showitems = "��� ...";

		$(".archive").html( showitems );
		$(".items:not(:lt("+items+"))").hide();

		$(".archive").click(function (e){
		  e.preventDefault();
		  if( $(".items:eq("+items+")").is(":hidden") )
		  {
			$(".items:hidden").show();
			$(".archive").html( hideitems );
		  }
		  else
		  {
			$(".items:not(:lt("+items+"))").hide();
			$(".archive").html( showitems );
		  }
		});
	});
</script>

<style>
	#dop-text {width:307px;}
	.hide {display:none;}
	#type-check label {cursor:pointer;}
	.tr-ur {display:none;}
    .not-exist {text-align: center; color: #777;}
</style>
</head>
  <body>
    <header>
      <div class="top-header">
        <div class="container">
          <div class="row">
            <div class="col-md-10 top-nav">
              <ul>
                <li><a href="#">�������</a></li>
                <li><a href="#">�����-����</a></li>
                <li><a href="#">����� � ������</a></li>
                <li><a href="#">���� ��������</a></li>
                <li><a href="#">���������</a></li>
                <li><a href="#">�����������</a></li>
                <li><a href="#">��������</a></li>
              </ul>
            </div>
            <div class="col-md-2 entry">
              <a href="#">����/</a>
              <a href="#">�����������</a>
            </div>
          </div>
        </div>
      </div>
      <div class="header-info">
        <div class="container">
          <div class="row header-desk">
            <div class="col-md-2 logo">
              <a href="#"><img src="img/tea/logo-big.png" alt="logo" width="180" height="80"></a>
            </div>
            <div class="col-md-3 cooperation">
              <p>����,  ����,  �. ������,<br>��. ������ �����  �. 12 �</p>
              <a href="#" class="button">�������������� � ���</a>
            </div>
            <div class="col-md-5 data-info">
              <div class="row ">
                <div class="col-md-6 data">
                  <p>����� ������:<br>��-�� � 9:00 �� 18:00</p>
                </div>
                <div class="col-md-6 phone">
                  <div class="phone-icon">
                    <img src="img/tea/phone.png" alt="phone" width="24" height="24">
                  </div>
                  <a href="tel:+79788649637">+7(978)8649637</a>
                  <a href="tel:+79781417930">+7(978)1417930</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
	<div class="bottom-nav">
		<div class="container">
			<div class="row">
				<div class="col-md-12 nav-bottom">
					<ul id="nav">
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=73">������������</a></li>
						<li class="items">
							<a href="http://tea.loc/index.php?route=product/category&amp;path=59">�������</a>
							<ul>
								<li><a href="http://tea.loc/index.php?route=product/category&amp;path=59_71">����� 1</a></li>
								<li><a href="http://tea.loc/index.php?route=product/category&amp;path=59_72">����� 2</a></li>
							</ul>
						</li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=60">������, �����</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=61">������� ���������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=62">�������� �������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=63">��������� ��������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=64">��������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=65">������� � ������������� �����</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=66">��������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=74">���������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=67">����� �������� ����</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=68">�������� ��������</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=69">������������� �����</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=70">�������� ����</a></li>

						<li><a href="#" class="archive"></a></li>
					</ul>
					  
				</div>
			</div>
		</div>
    </div>
	
	<section >
		<div class="container">
			<div>
				<form onsubmit="return vilidOrd()" action="invoice.php" method="post" enctype="multipart/form-data">
				
				   <div id="order-info">
					   <p>
							<div>��������� ���� �� 10 000 ���, ������ ��� �� 10 000 ���. �� 20 000 ���, ��� �� 20 000 �� 300 000 ���, ����� 300 000��� - ������� ���.</div>
						</p>
					   
							<select id="type">
								<option <?=$sel_type[5]?> value="5">�����������</option>
								<option <?=$sel_type[4]?> value="4">������� ���</option>
								<option <?=$sel_type[3]?> value="3">���</option>
								<option <?=$sel_type[2]?> value="2">������ ���</option>
								<option <?=$sel_type[1]?> value="1">�������</option>
							</select>
					</div>
					
					<?php
						$queryTov=mysql_query("SELECT *, `Tovari`.`id` as `idTov`, `Tovari`.`img` as `fotoTov`, `categories`.`id` as `idCat`, `link` as link
												FROM  `Tovari` 
												LEFT JOIN  `categories` ON  `Tovari`.`idCat` =  `categories`.`id` 
												WHERE   `title` <> '' and `categories`.`id` is not null
												ORDER BY   ord, ord1 ");
						 
						if(mysql_num_rows($queryTov)>0 ){
							$catTitle = '';
					?>
						<div id="pticeTable">
							<div class="trH">
								<span>����</span>
								<span>������������</span>
								<span>����, <?php echo $currency; ?></span>
								<span>���-��</span>
								<span>�����, <?php echo $currency; ?></span>
							</div>
					<?php
							while($rowTov=mysql_fetch_array($queryTov)) {
								$cat = $rowTov['nam_categories'];
								$tovar = $rowTov['title'];
								$not_exist = $rowTov['not_exist'];
								
								$cena2 = $rowTov['cost_opt_ru'];
								$id = $rowTov['idTov'];
								$link_product = $rowTov['link_product'];
								$idCat = $rowTov['link'];
								$foto = $rowTov['fotoTov'];

								if(!empty($foto)){
									$path = 'img/tovar/';
									
									list($width, $height) = getimagesize($path.$foto);
									
									$fotos = $path.$foto;
								}else{
									$fotos = 'img/tea/no_image.png';
								}
								
								if($country == 'ru'){
									$field = $cost_ru_arr[$type];
									$cena = $rowTov[$field];
								}else if($country == 'ua'){
									$field = $cost_ua_arr[$type];
									$cena = $rowTov[$field];
								}
								
								if($catTitle <> $cat){
									$catTitle = $cat;

						?>
							<div>
								<span class="nameCat">
									<?php if($idCat){ ?>
										<span class="name-category"><a href="<?php echo $idCat; ?>"><?php echo $cat; ?></a></span>
									<?php }else{ ?>
										<span class="name-category"><?php echo $cat; ?></span>
									<?php } ?>
								</span>
							</div>
						<?php
								}
								
								if($not_exist == 0){
									$class_tr = '';
								}else{
									$class_tr = '-null';   
								}											
						?>
							<div idN="<?php echo $id; ?>" class="cartTr2<?php echo $class_tr; ?>">
								
								<span w="<?php echo $width; ?>" foto="<?php echo $fotos; ?>" class="fotoTd"><img src="<?php echo $fotos; ?>" height="15" width="20"></span>
								
								<?php if($link_product){ ?>
									<span class="name-product"><a href="<?php echo $link_product; ?>"><?php echo $tovar; ?></a></span>
								<?php }else{ ?>
									<span class="name-product"><?php echo $tovar; ?></span>
								<?php } ?>
								
								<?php if($not_exist == 0){ ?>
									<span id="cena<?php echo $id; ?>"><?php echo $cena; ?> </span>
									<input type="hidden" value="<?php echo $cena; ?>" name="cena[<?php echo $id; ?>]">
									<input autocomplete="off" name="kol[<?php echo $id; ?>]" tov="<?php echo $id; ?>" class="kol" type="text" size="3" value="">
									<span id="summ_<?php echo $id; ?>"></span>
									<input type="hidden" name="idTov[<?php echo $id; ?>]" value="<?php echo $id; ?>" />
								<?php }else{ ?>
									<span class="not-exist" colspan="3">�������� ��� �� ������</span>
								<?php } ?>
								
							</div>
						<?php
							}
						?>
							<div>
								<div colspan="3" align="right"> <b id="allSumm-text"></b> </div>
								<div id="amount"></div>
								<div> <b id="allSumm"></b></div>
							</div>
						</div>				
						<?php
						}
						?>

					<div id="type-check">
						<label>
							<input name="type_lico" checked="checked" type="radio" value="0" />
							��� ����
						</label>
						&nbsp;
						<label>
							<input name="type_lico" type="radio" value="1" />
							�� ����
						</label>
					</div>
					<div class="tr-ur">
					������������
					<input placeholder="" id="ur-name" type="text" name="ur_name" value="" size="40" />
					</div>
					<div class="tr-ur">
						���
						<input placeholder="" id="ur-inn" type="text" name="ur_inn" value="" size="40" />
					</div>
					<div class="tr-ur">
						����
						<input placeholder="" id="ur-ogrn" type="text" name="ur_ogrn" value="" size="40" />
					</div>
					<div class="tr-ur">
					��. �����
					<input placeholder="" id="ur-adres" type="text" name="ur_adres" value="" size="40" />
					</div>
					���
					<input placeholder="�������, ���, ��������" id="baskN" type="text" name="name2" value="" size="40" />
					��� �������
					<input  id="baskT" type="text" name="tel" value="" size="40" />
					��� email
					<input  id="email" type="text" name="email" value="" size="40" />
					������ ��������
					<input  id="baskD" type="text" name="dos" value="" size="40" />
					������
					<input  id="baskCou" type="text" name="country_name" value="" size="40" />
					�����
					<input  id="baskC" type="text" name="city" value="" size="40" />
					�����������
					<textarea id="dop-text" name="dop" rows="4"></textarea>

					<input type="submit" value="���������" />

					<input type="hidden" name="country" value="<?=$country?>" />
					<input type="hidden" name="type" value="<?=$type?>" />
				</form>
			</div>
		</div>
    </section>
	
	<footer>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="footer-content">
              <div class="footer-nav">
                <nav>
                  <a href="#">�������</a>
                  <a href="#">�����-����</a>
                  <a href="#">����� � ������</a>
                  <a href="#">���� �������� </a>
                  <a href="#">��������� </a>
                  <a href="#">�����������</a>
                  <a href="#">����</a>
                  <a href="#">��������</a>
                </nav>
              </div>
              <div class="footer-product">
                <nav>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=59">�������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=60">������, �����</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=61">������� ���������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=62">�������� �������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=63">��������� ��������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=64">��������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=65">������� � ������������� �����</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=66">��������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=67">����� �������� ����</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=68">�������� ��������</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=69">������������� �����</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=70">�������� ����</a>
                </nav>
              </div>
              <div class="footer-company">
                <div class="address-wrapper">
                  <div class="address">
                    <p>����,  ����,  �. ������,<br>��. ������ �����  �. 12 �</p>
                  </div>
                  <div class="email-footer">
                    <a href="mailto:tea-crimea@yandex.ru">E-mail: tea-crimea@yandex.ru</a>
                  </div>
                </div>
                <div class="footer-data">
                  <p>����� ������:<br>��-�� � 9:00 �� 18:00</p>
                </div>
                <div class="phone-footer">
                  <a href="tel:+79788649637" class="phone-big">+7(978)8649637</a>
                  <a href="#">�������� ������</a>
                  <a href="#">��������� �����</a>
                </div>
              </div>
              <div class="copy">
                <h2>2008 - 2019 � ��� ����� �������� ���� ����� �</h2>
                <p>���� ���������� � <span> <a href="http://mkvadrat.com" target="_blank"><img src="img/tea/logo-com.png" alt="logo" width="32" height="32"></a>  </span></p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="map">
                <div id="map"></div>
            </div>
          </div>
        </div>
      </div>
	  <img id="fotoTov" src=""  />
    </footer>
  </body>
</html>