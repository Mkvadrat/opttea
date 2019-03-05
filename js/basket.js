
$(function(){
	$('.kol').keyup(function(){
		calc();
	});
	
	$(".fotoTd").hover(
	  function (e) {
		img = $(this).attr('foto');
		w = $(this).attr('w');
		topY =e.pageY-50;
		left = e.pageX-w-70;
		$('#fotoTov').css('left', left);
		$('#fotoTov').css('top', topY);
		$('#fotoTov').css('display', 'block');
		$('#fotoTov').attr('src', img);
	  }, 
	  function () {
		$('#fotoTov').css('display', 'none');
	  }
	);
	
	$('#country, #type').change(function(){
		type_location();
	});
	
});

function type_location(){
	var c = $('#country option:selected').val();
	var t = $('#type option:selected').val();
	c = 'ru';
	top.location = '/?country='+c+'&type='+t;	
}


function calc(){
	var allSumm = 0;
	var allSumm2 = 0;
	var amounts = 0;
	$(".cartTr2").each(function (i) {
		id = $(this).attr('idN');
		cena = $('#cena'+id).text();
		cena2 = $('#cena2'+id).text();
		kol = $('.kol[tov='+id+']').val();
		
		if(kol != ''){
			kol = parseInt(kol);
			amounts +=kol;
		}
		
		sum = cena*kol;
		sum2 = cena2*kol;
		
		console.log(id, cena, cena2, kol, sum, sum2);		
		
		if(sum !== 0){
			$('#summ_'+id).html(sum);
		}else{
			$('#summ_'+id).html('');
		}

		allSumm +=sum;
		//console.log(allSumm)
	});	
	
	$('#amount').html(parseInt(allSumm)+' шт.');
	$('#allSumm-text').html('Итого:');
	$('#allSumm').html(allSumm+' '+currency);
	
	
	/*if(allSumm > 300000){
		$('.sale-tr').show();
		sum_sale = allSumm*0.05;
		$('#allSumm-sale').html(sum_sale+' '+currency);
		$('#allSumm-sale2').html((allSumm-sum_sale)+' '+currency);
	}else{
		$('.sale-tr').hide();
	}*/
}

function vilidOrd(){
	sum = $('#allSumm').html();
	sum = Number(sum.replace(/\D+/g,""));
	if(sum <= limitSum){
		alert('Заказ должен быть не меенее, чем на '+limitSum+' '+currency);
		return false;	
	}

	
	 var reg= new RegExp('^[a-z0-9\._-]+@[a-z0-9][a-z0-9_-]*(\.[a-z0-9_-]+)*'+
                         '\.([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|'+
                         'int|mil|museum|name|net|org|pro|travel)$', 'i')
		em = $('#email').val();
		
		
	if($('#baskN').val() == '' || 	$('#baskT').val() == ''  || $('#baskD').val() == '' || $('#baskC').val() == '' || $('#baskN').val() == null || 	$('#baskT').val() == null || $('#baskD').val() == null || $('#baskC').val() == null){
		alert('Заполните Имя, Телефон, Способ доставки, Город');
		return false;
	}else{
		if(em == ''){
			return true;
		}else{
			if (!reg.test(em)) {
				alert('Вы ввели некорректный e-mail');
				return false;
			}else{
				return true;
			}
		}
		
	}
}