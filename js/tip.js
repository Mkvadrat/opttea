
	function disp(id,event) {
		dis = document.getElementById(id);
		if (document.attachEvent != null) {
			
			dis.style.display="block";
			dis.style.top= (window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop);
			dis.style.left=(window.event.clientX + 10);
			
      } else if (!document.attachEvent && document.addEventListener) {
		  dis.setAttribute("style","display:block;" + "top:" +  (event.clientY + window.scrollY) + "px; left:" + (event.clientX + 10 ) + "px;");
      }
	}
	
	function dispOut(id) {
		
		if (document.attachEvent != null) {
			dis.style.display="none";
      } else if (!document.attachEvent && document.addEventListener) {
		 dis = document.getElementById(id);
		dis.setAttribute("style","");
      }
		
	}