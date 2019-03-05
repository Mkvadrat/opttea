

$(function(){
		 /*$('#selPr')
          .bind('dblclick',function(event) {
				val = $(this).val();
				top.location = 'cat.php?page=' + val;
          })	
		  
		  $('#selPrCat')
          .bind('click',function(event) {
				idCat = $(this).val();
				if (idCat != null) {
					$('.id_hide').val(idCat);
				}
          })
		  
		  $('#selPrUndUndCat')
          .bind('click',function(event) {
				idCat = $(this).val();
				if (idCat != null) {
					list = idCat.split("|")
					$('.id_hide').val(list[0]);
					$('#cena').val(list[1]);
				}
          })
		  
		  $('#selPrCat')
          .bind('dblclick',function(event) {
				val = $(this).val();
				page = $('#page').val();
				top.location = 'undcat.php?page=' + page + '&idcat=' + val;
          })
		  
		  $('#selPrUndCat')
          .bind('click',function(event) {
				idCat = $(this).val();
				if (idCat != null) {
					list = idCat.split("|")
					$('.id_hide').val(list[0]);
					$('#cena').val(list[1]);
					
				}
          })
		  
		  
		   $('#selPrUndCat')
          .bind('dblclick',function(event) {
				val = $(this).val();
				page = $('#page').val();
				idCat = $('#idCat').val();
				
				list = val.split("|")
				
				top.location = 'undundcat.php?page=' + page + '&idcat=' + idCat + '&idundcat=' + list[0];
          })
		  
		  $('#selPrUndUndCat')
          .bind('dblclick',function(event) {
				val = $(this).val();
				page = $('#page').val();
				idCat = $('#idCat').val();
				idundCat = $('#idundcat').val();
					
				txtVal = this.options[this.selectedIndex].text
				
				if(txtVal == '[text]'){
					top.location = 'undundcattext.php?page=' + page + '&idcat=' + idCat + '&idundcat=' + idundCat + '&idundundcat=' + val;
				}else{
					alert('Кликните по [text]');
				}
          })*/
		  
		  
});



function saved(){
	$('#saved').html('сохранено');
	$('#saved').stop().css('opacity', 100);
	$('#saved').show();	
	$('#saved').fadeOut(2000);
}

function save(){
	$('#saved').show().html('<img src="/img/load.gif" />');
}