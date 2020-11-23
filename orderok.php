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
				<li><a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=4">О нас</a></li>
				<li><a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=7">Прайс-лист</a></li>
				<li><a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=11">Заказ и оплата</a></li>
				<li><a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=8">Наши магазины</a></li>
				<li><a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=9">Документы</a></li>
				<li><a href="http://tea-crimea.ru/index.php?route=information/contact">Контакты</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="header-info">
        <div class="container">
          <div class="row header-desk">
            <div class="col-md-2 logo">
              <a href="http://tea-crimea.ru/"><img src="img/tea/logo-big.png" alt="logo" width="180" height="80"></a>
            </div>
            <div class="col-md-3 cooperation">
              <p>Крым,  Ялта,  г. Алупка,<br>ул. Крутой спуск  д. 12 а</p>
              <!--<a href="#" class="button">Сотрудничество и опт</a>-->
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
                  <a href="tel:+79782184408">+79782184408</a>
				  <a href="tel:+79787528287">+79787528287</a>
				  <a href="tel:+79781417930">+79781417930</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
	<!--<div class="bottom-nav">
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
    </div>-->
	
	<section >
		<div class="container">
			<div class="cenText">
				<h3 style="font-family:Verdana, Geneva, sans-serif; color:#666;" align="center">Ваш заказ принят в обработку. Спасибо<br /><br />Вам на почту придет письмо со счетом для оплаты</h3>
				<div class="col-12 cooperation">
				<a href="/" class="button cont-ok-btn">Ок</a>
				</div>
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
					<a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=9">Документы</a>
					<a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=7">Прайс-лист</a>
					<a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=11">Заказ и оплата</a>
					<a href="http://tea-crimea.ru/index.php?route=information/information&amp;information_id=8">Наши магазины</a>
					<a href="http://tea-crimea.ru/index.php?route=information/news">Блог</a>
					<a href="http://tea-crimea.ru/index.php?route=information/contact">Контакты</a>
				</nav>
              </div>
              <!--<div class="footer-product">
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
              </div>-->
              <div class="footer-company">
                <div class="address-wrapper">
                  <div class="address">
                    <p>Крым,  Ялта,  г. Алупка,<br>ул. Крутой спуск  д. 12 а</p>
                  </div>
                  <div class="email-footer">
                    <a href="mailto:info@tea-crimea.ru">E-mail: info@tea-crimea.ru</a>
                  </div>
                </div>
                <div class="footer-data">
                  <p>Время работы:<br>Пн-Пт с 9:00 до 18:00</p>
                </div>
                <div class="phone-footer">
                  <a href="tel:+79782184408" class="phone-big">+79782184408</a>
				  <a href="tel:+79787528287" class="phone-big">+79787528287</a>
                  <a href="tel:+79781417930" class="phone-big">+79781417930</a>
                  <!--<a href="#">Обратный звонок</a>
                  <a href="#">Отследить заказ</a>-->
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