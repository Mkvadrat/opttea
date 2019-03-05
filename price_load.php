<?php
require('fpdf.php');
include ("blocks/db.php"); /*Соединение с базой*/
//create a FPDF object
$pdf=new FPDF();

$x=0;
$y=0;
//set document properties
$pdf->SetAuthor('Silver');
$pdf->SetTitle('FPDF');

//set font for the entire document
$pdf-> AddFont('TimesNewRomanPSMT','','times.php'); 
$pdf->SetFont('TimesNewRomanPSMT','',12);
$pdf->SetTextColor(0,0,0);

$pdf->AddPage('P');
$pdf->SetDisplayMode('real','default');
//$pdf->Image('logo.png',160,10,40,25,'png','http://www.tea.crimea.ua/');

$x=90;
$y=10;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(14);
$pdf->Write(5,'УКРАИНА');

$x=55;
$y=18;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(14);
$pdf->Write(5,'АВТОНОМНАЯ РЕСПУБЛИКА КРЫМ');

$x=78;
$y=26;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(14);
$pdf->Write(5,'ТМ   «ЧАИ КРЫМА»');

$x=10;
$y=36;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(12);
$pdf->Write(5,'Крым, г.Ялта');


$x=135;
$y=36;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(12);
$pdf->Write(5,'тел. 8(0654)72-21-80, 72-12-86');

$x=45;
$y=50;

$pdf->SetXY ($x,$y);
$pdf->SetFontSize(12);
$pdf->Write(5,'ПРАЙС-ЛИСТ   на продукцию ТМ «ЧАИ КРЫМА»');

$x1=10;
$y1=57;

$x2=200;
$y2=57;

$yVertStart=57;
//горизонтальная линия(Откр)
$pdf->Line($x1,$y1,$x2,$y2);



$x=13;
$y=62;

$pdf->Text($x, $y, '№');// х от 10 до 19
$pdf->Line(19,$yVertStart,19,$y+1);

$x=20;
$y=62;

$pdf->Text($x, $y, 'НАЗВАНИЕ');// х от 19 до 47
$pdf->Line(47,$yVertStart,47,$y+1);

$x=68;
$y=62;

$pdf->Text($x, $y, 'СОСТАВ');// х от 47 до 107
$pdf->Line(107,$yVertStart,107,$y+1);

$x=118;
$y=62;

$pdf->Text($x, $y, 'НАЗНАЧЕНИЕ');// х от 107 до 160
$pdf->Line(107,$yVertStart,107,$y+1);

$x=173;
$y=62;

$pdf->Text($x, $y, 'ЦЕНА*');// х от 160 до 200
$pdf->Line(160,$yVertStart,160,$y+1);

$x1=10;
$y1=57+6;

$x2=200;
$y2=63;

$pdf->Line($x1,$y1,$x2,$y2);
$Kvo=1;
$forprice = mysql_query ("SELECT id, nam_categories FROM categories",$db);
	
	if (!$forprice) {
		$pdf->Error('Произошла ошибка. Пожалуйста напишите администратору');
		
	} else {
		if (mysql_num_rows($forprice)>0){
			while ($Rowprice=mysql_fetch_array($forprice)) {		
								
				$forprice_tov = mysql_query ("SELECT title, Sostav, Naznachenie,   	
priceOpt, priceMelk, priceRoznica FROM Tovari WHERE idCat='$Rowprice[id]' ",$db);
	
				if (!$forprice_tov) {
					$pdf->Error('Произошла ошибка. Пожалуйста напишите администратору');
				} else {
					if (mysql_num_rows($forprice_tov)>0){
												
						$pdf->SetFontSize(10);
						$x=(190-strlen($Rowprice['nam_categories'])*2)/2+10;
						$y=$y+5;
						$pdf->Text($x, $y, $Rowprice['nam_categories']);
						
						$y2=$y+1;

						$pdf->Line(10,$y2,200,$y2);
						$pdf->SetFontSize(8);
						$yMax=$y+5;
						while ($Rowtov=mysql_fetch_array($forprice_tov)) {
							
							$yTitle=$yMax;
							for($i=13;$i<=strlen($Rowtov['title'])+12;$i=$i+13){
									$yTitle=$yTitle+5;
							}
							
							$ySostav=$yMax;
							for($i=28;$i<=strlen($Rowtov['Sostav'])+27;$i=$i+28){
									$ySostav=$ySostav+5;
							}
			
							$yNaznach=$yMax;
							for($i=25;$i<=strlen($Rowtov['Naznachenie'])+24;$i=$i+25){
									$yNaznach=$yNaznach+5;
							}
							if (($yNaznach>=285) or ($yTitle>=285) or ($ySostav>=285)){
								//вертикальная линия
								$pdf->Line(10,$yVertStart,10,$y);
								$pdf->Line(200,$yVertStart,200,$y);
								$pdf->AddPage('P');	
								$yMax=15;
								$y=9;
								$yVertStart=10;
								$pdf->Line(10,10,200,10);
							}
							// проверка на новую стр (Конец)							
							
							
							
							// выводим порядковый номер
							$x=(9-strlen($Kvo)*1.5)/2+10;
							$pdf->Text($x, $yMax, $Kvo);
							$Kvo=$Kvo+1;
			
							// выводим название 
							$yTitle=$yMax;
							for($i=13;$i<=strlen($Rowtov['title'])+12;$i=$i+13){
									$pdf->Text(20, $yTitle, substr($Rowtov['title'],$i-13,13));
									$yTitle=$yTitle+4;
							}
							
							// выводим состав
							$ySostav=$yMax;
							for($i=28;$i<=strlen($Rowtov['Sostav'])+27;$i=$i+28){
									$pdf->Text(48, $ySostav, substr($Rowtov['Sostav'],$i-28,28));
									$ySostav=$ySostav+4;
							}
							
							// выводим назначение
							$yNaznach=$yMax;
							for($i=24;$i<=strlen($Rowtov['Naznachenie'])+23;$i=$i+24){
									$pdf->Text(108, $yNaznach, substr($Rowtov['Naznachenie'],$i-24,24));
									$yNaznach=$yNaznach+4;
							}
							
							// выводим цены
							$price=$Rowtov['priceOpt'].".00 /".$Rowtov['priceMelk'].".00 /".$Rowtov['priceRoznica'].".00";
							//$yNaznach=$yMax;
							
									$pdf->Text(161, $yMax, $price);
									$yNaznach=$yNaznach+4;
							
							
							//Находим максимальный
							if ($ySostav>=$yTitle){
								if($ySostav>=$yNaznach){
									$yMax=$ySostav;
								} else {
									$yMax=$yNaznach;
								}
							} else {
								if($yTitle>=$yNaznach){
									$yMax=$yTitle;
								} else {
									$yMax=$yNaznach;
								}
							}
							
							$pdf->Line(19,$y+1,19,$yMax-3);
							$pdf->Line(47,$y+1,47,$yMax-3);
							$pdf->Line(107,$y+1,107,$yMax-3);
							$pdf->Line(160,$y+1,160,$yMax-3);
							$pdf->Line(10,$yMax-3,200,$yMax-3);
							$yMax=$yMax-4;
							$y=$yMax;
							$yMax=$yMax+4;

						}
					}
				}
			}
			
		} else {
			$pdf->Error('Произошла ошибка. Пожалуйста напишите администратору');
		}
	}

//$pdf->Line(5,10,5,285);
$y=$y+1;
//горизонтальная линия(Закрывающая)
$pdf->Line($x1,$y,$x2,$y);


//вертикальная линия
$pdf->Line(10,$yVertStart,10,$y);
$pdf->Line(200,$yVertStart,200,$y);

$x=20;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"Розничная  цена  до 1000 грн. /  мелкий  опт  до 3000 грн. /  крупный опт по договоренности");
	
$pdf->SetFontSize(10);

$date=date("d.m.yг.");
$x=20;
$y=$y+10;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,$date);
	
$x=150;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"www.tea.crimea");
	
	$x=150;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"E-mail tea-crimea@yandex.ru");


$x=20;
$y=$y+10;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"Васильев Юрий Геннадьевич 8 (067) 563 27 66");
	
	$x=20;
$y=$y+10;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"Реквизиты для оплаты. «Правекс-Банк» на Васильева Ю.Г.");
	
	
	$x=20;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"Безналичный расчет    СПД ФЛ  Васильев Г.Б.");
	
	$x=71;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"Р/С 26002501906 в Ялтинском отд.4549");
	
	
	$x=71;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"ОАО «Ощадбанк»  МФО384038");
	
	
	$x=71;
$y=$y+5;
if($y>=285){
	$pdf->AddPage('P');	
	$y=10;	
}
	$pdf->Text($x,$y,"ОКПО  1785216075 ");


$pdf->Output('Price-list.pdf','D');
?>
