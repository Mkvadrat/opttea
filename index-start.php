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
	$currency = 'руб';	
}else if($country == 'ua'){
	$currency = 'грн';	
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
			<!--Скрыть элементы управления: controls: []	 -->
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
			hintContent: 'Компания "Lorem"'
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
			iconCaption: 'Крутой переулок'
		}, {
			preset: 'islands#greenDotIconWithCaption'
		}))
	}
	//end maps
	$(document).ready(function() {
		//js theme functions
		var items = 6; // - количество отображаемых новостей
		hideitems = "Скрыть категории";
		showitems = "Еще ...";

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
                <li><a href="#">Каталог</a></li>
                <li><a href="#">Прайс-лист</a></li>
                <li><a href="#">Заказ и оплата</a></li>
                <li><a href="#">Наши магазины</a></li>
                <li><a href="#">Документы</a></li>
                <li><a href="#">Франчайзинг</a></li>
                <li><a href="#">Контакты</a></li>
              </ul>
            </div>
            <div class="col-md-2 entry">
              <a href="#">Вход/</a>
              <a href="#">Регистрация</a>
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
              <p>Крым,  Ялта,  г. Алупка,<br>ул. Крутой спуск  д. 12 а</p>
              <a href="#" class="button">Сотрудничество и опт</a>
            </div>
            <div class="col-md-5 data-info">
              <div class="row ">
                <div class="col-md-6 data">
                  <p>Время работы:<br>Пн-Пт с 9:00 до 18:00</p>
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
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=73">Фитонастойки</a></li>
						<li class="items">
							<a href="http://tea.loc/index.php?route=product/category&amp;path=59">Фиточаи</a>
							<ul>
								<li><a href="http://tea.loc/index.php?route=product/category&amp;path=59_71">Пункт 1</a></li>
								<li><a href="http://tea.loc/index.php?route=product/category&amp;path=59_72">Пункт 2</a></li>
							</ul>
						</li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=60">Стевия, травы</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=61">Медовая продукция</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=62">Крымское варенье</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=63">Восточные сладости</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=64">Пряности</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=65">Эфирные и косметические масла</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=66">Сувениры</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=74">Глинтвейн</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=67">Живое Крымское мыло</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=68">Крымские бальзамы</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=69">Косметические масла</a></li>
						<li class="items"><a href="http://tea.loc/index.php?route=product/category&amp;path=70">Фигурное мыло</a></li>

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
							<div>Розничная цена до 10 000 руб, мелкий опт от 10 000 руб. до 20 000 руб, опт от 20 000 до 300 000 руб, свыше 300 000руб - крупный опт.</div>
						</p>
					   
							<select id="type">
								<option <?=$sel_type[5]?> value="5">Франчайзинг</option>
								<option <?=$sel_type[4]?> value="4">Крупный опт</option>
								<option <?=$sel_type[3]?> value="3">Опт</option>
								<option <?=$sel_type[2]?> value="2">Мелкий опт</option>
								<option <?=$sel_type[1]?> value="1">Розница</option>
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
								<span>фото</span>
								<span>Наименование</span>
								<span>Цена, <?php echo $currency; ?></span>
								<span>Кол-во</span>
								<span>Сумма, <?php echo $currency; ?></span>
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
									<span class="not-exist" colspan="3">временно нет на складе</span>
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
							Физ лицо
						</label>
						&nbsp;
						<label>
							<input name="type_lico" type="radio" value="1" />
							Юр лицо
						</label>
					</div>
					<div class="tr-ur">
					Наименование
					<input placeholder="" id="ur-name" type="text" name="ur_name" value="" size="40" />
					</div>
					<div class="tr-ur">
						ИНН
						<input placeholder="" id="ur-inn" type="text" name="ur_inn" value="" size="40" />
					</div>
					<div class="tr-ur">
						ОГРН
						<input placeholder="" id="ur-ogrn" type="text" name="ur_ogrn" value="" size="40" />
					</div>
					<div class="tr-ur">
					Юр. адрес
					<input placeholder="" id="ur-adres" type="text" name="ur_adres" value="" size="40" />
					</div>
					Фамилия
					<input placeholder="фамилия" id="baskN" type="text" name="name2" value="" size="40" />
					Имя
					<input placeholder="имя" id="firstname" type="text" name="firstname" value="" size="40" />
					Отчество
					<input placeholder="отчество" id="patronymic" type="text" name="patronymic" value="" size="40" />
					Ваш телефон
					<input  id="baskT" type="text" name="tel" value="" size="40" />
					Ваш email
					<input  id="email" type="text" name="email" value="" size="40" />
					Способ доставки
					<input  id="baskD" type="text" name="dos" value="" size="40" />
					Страна
					<input  id="baskCou" type="text" name="country_name" value="" size="40" />
					Город
					<input  id="baskC" type="text" name="city" value="" size="40" />
					Комментарий
					<textarea id="dop-text" name="dop" rows="4"></textarea>

					<input type="submit" value="отправить" />

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
                  <a href="#">Каталог</a>
                  <a href="#">Прайс-лист</a>
                  <a href="#">Заказ и оплата</a>
                  <a href="#">Наши магазины </a>
                  <a href="#">Документы </a>
                  <a href="#">Франчайзинг</a>
                  <a href="#">Блог</a>
                  <a href="#">Контакты</a>
                </nav>
              </div>
              <div class="footer-product">
                <nav>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=59">Фиточаи</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=60">Стевия, травы</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=61">Медовая продукция</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=62">Крымское варенье</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=63">Восточные сладости</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=64">Пряности</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=65">Эфирные и косметические масла</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=66">Сувениры</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=67">Живое Крымское мыло</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=68">Крымские бальзамы</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=69">Косметические масла</a>
					<a href="http://tea.loc/index.php?route=product/category&amp;path=70">Фигурное мыло</a>
                </nav>
              </div>
              <div class="footer-company">
                <div class="address-wrapper">
                  <div class="address">
                    <p>Крым,  Ялта,  г. Алупка,<br>ул. Крутой спуск  д. 12 а</p>
                  </div>
                  <div class="email-footer">
                    <a href="mailto:tea-crimea@yandex.ru">E-mail: tea-crimea@yandex.ru</a>
                  </div>
                </div>
                <div class="footer-data">
                  <p>Время работы:<br>Пн-Пт с 9:00 до 18:00</p>
                </div>
                <div class="phone-footer">
                  <a href="tel:+79788649637" class="phone-big">+7(978)8649637</a>
                  <a href="#">Обратный звонок</a>
                  <a href="#">Отследить заказ</a>
                </div>
              </div>
              <div class="copy">
                <h2>2008 - 2019 © Все права защищены «Чаи Крыма» ™</h2>
                <p>Сайт разработан в <span> <a href="http://mkvadrat.com" target="_blank"><img src="img/tea/logo-com.png" alt="logo" width="32" height="32"></a>  </span></p>
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