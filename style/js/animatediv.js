
var timerlen = 5;
var slideAniLen = 500;

var timerID = new Array();
var startTime = new Array();
var obj = new Array();
var endHeight = new Array();
var moving = new Array();
var dir = new Array();

function slidedown(objname){
  if(moving[objname])
    return;
 
  if(document.getElementById(objname).style.display != "none")
    return; // cannot slide down something that is already visible
 
  moving[objname] = true;
  dir[objname] = "down";
  startslide(objname);
}
 
function slideup(objname){
  if(moving[objname])
    return;
 
  if(document.getElementById(objname).style.display == "none")
    return; // cannot slide up something that is already hidden
 
  moving[objname] = true;
  dir[objname] = "up";
  startslide(objname);
}

function startslide(objname){
  obj[objname] = document.getElementById(objname);

  var s = obj[objname].style.height;
  var d = parseInt(s);
  endHeight[objname] = d;
  startTime[objname] = (new Date()).getTime();
 
  if(dir[objname] == "down"){
    obj[objname].style.height = "1px";
  }
 
  obj[objname].style.display = "block";
 
  timerID[objname] = setInterval('slidetick("' + objname + '");', timerlen);
}

function slidetick(objname){
  var elapsed = (new Date()).getTime() - startTime[objname];
 
  if (elapsed > slideAniLen)
    endSlide(objname)
  else {
    var d =Math.round(elapsed / slideAniLen * endHeight[objname]);
    if(dir[objname] == "up")
      d = endHeight[objname] - d;
 
    obj[objname].style.height = d + "px";
  }
 
  return;
}

function endSlide(objname){
  clearInterval(timerID[objname]);
 
  if(dir[objname] == "up")
    obj[objname].style.display = "none";
 
  obj[objname].style.height = endHeight[objname] + "px";
 
  delete(moving[objname]);
  delete(timerID[objname]);
  delete(startTime[objname]);
  delete(endHeight[objname]);
  delete(obj[objname]);
  delete(dir[objname]);
 
  return;
}

function toggleDiv(divid){
    if(document.getElementById(divid).style.display == 'none'){
      slidedown(divid);
    }else{
      slideup(divid);
    }
}

function hidesignup(){
    var obj=document.getElementById('registerForm');
    var h=obj.clientHeight;
    obj.style.display='none';
    obj.style.height=h+'px';
    obj.style.visibility='visible';
}
