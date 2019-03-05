function init(id) {
  var obj = document.getElementById(id);
  if (obj) {
    obj.state = 0;
    obj.timer = null;
    obj.maxVert = obj.scrollHeight - obj.offsetHeight;
  }
}

function scroll_down(id,timer) {
  var obj = document.getElementById(id);
  if (!obj.maxVert) init(id);
  if (timer == undefined) obj.state = 1;
  if ((obj.maxVert > obj.scrollTop) && (obj.state == 1)) {
    obj.scrollTop = obj.scrollTop + 25;
    obj.timer = setTimeout('scroll_down(\''+id+'\',true)',100);
  }
} 

function scroll_up(id,timer) {
  var obj = document.getElementById(id);
  if (!obj.maxVert) init(id);
  if (timer == undefined) obj.state = -1;
  if ((obj.scrollTop > 0) && (obj.state == -1)) {
    obj.scrollTop = obj.scrollTop > 10 ? obj.scrollTop - 25 : 0;
    obj.timer = setTimeout('scroll_up(\''+id+'\',true)',100);
  }
}


function scroll_stop(id) {
  var obj = document.getElementById(id);
  if (obj) {
    if (obj.timer) clearTimeout(obj.timer);
    obj.state = 0;
  }

}