<div id="callback-btn">������ ������</div>
<div class="popup-frame2" id="callback-frame" >
	<div class="callback-close">X</div>
	<div id="callback-frame-top">
    	<div>������ ������</div>
        <span>�� ������� � ������� �������� ���</span>
    </div>
    <div id="callback-frame-content">
    	<div id="callback-form">
            <input id="callback-phone" placeholder="��� ����� ����������" type="text" class="fl">
            <input id="callback-email" placeholder="����� ����������� �����" type="text" class="fr">
            <br class="cb">
            <textarea rows="5" id="callback-msg" placeholder="���� ���������"></textarea>
            
            <div data-id="286" class="mt20" id="callback-send">��������� ���������</div>
        </div>
        <div id="callback-thanks" >��������� ���������, �������!</div>
    </div>
</div>

<div class="popup-frame2" id="search-ord-frame" >
	<div class="callback-close">X</div>
    <div id="search-ord-content">
    	<input id="search-ord-contact" type="text" value="" placeholder="������� ��� e-mail" />
        <input id="search-ord-ord" type="text" value="" placeholder="����� ������" />
        <div id="search-ord-btn">��������� �����</div>
    </div>
</div>


<script>
    $(function(){
        $('#callback-btn').click(function(e){
            e.stopPropagation();
            $('#callback-frame').show();
            $('#callback-frame-content').show();
            $('#callback-thanks').hide();
        });
        
        $('#search-ord-ord, #search-ord-contact').keydown(function(e){
            var sym = e.keyCode;
            
            if(sym === 13){
                $('#search-ord-btn').click();
            }
        });
        
        $('#callback-frame, .popup-frame2').click(function(e){
            e.stopPropagation();
        });
        
        $(document).click(function(){
            $('#callback-frame, .popup-frame2').hide();
        });
        $('#callback-close, .callback-close').click(function(){
            $(document).click();
        });
        
        $('#callback-send').click(function(){
           var phone = $('#callback-phone').val();
           var email = $('#callback-email').val();
           var msg = $('#callback-msg').val();
           
           $('#callback-frame-content').slideUp('fast');
           $('#callback-thanks').slideDown('fast');
           
           $.post('ajax-callback.php', {phone:phone, email:email, msg:msg}, function(){
               
           });
        });
		
		
		$('#login-head').click(function(e){
            e.stopPropagation();
            $('#search-ord-frame').show();
           
        });
		
		$('#search-ord-btn').click(function(){
			var t = this;
			var contact = $('#search-ord-contact').val();
			var ord = $('#search-ord-ord').val();
			
			$(t).html('�����');
			$.post('zakaz.php', {find_ord:1, contact:contact, ord:ord}, function(data){
				if(data == 1){
					top.location = '/zakaz.php';
				}else{
					alert(data);	
				}
			});
		});
		
		$('#zakaz-search').click(function(e){
			e.stopPropagation();
			$('#login-head').click();
		});
        
        
    });
</script>