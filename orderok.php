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
			<div class="cenText">
				<h3 style="font-family:Verdana, Geneva, sans-serif; color:#666;" align="center">��� ����� ������ � ���������. �������<br /><br />��� �� ����� ������ ������ �� ������ ��� ������</h3>
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