console.log(window.innerWidth);

var win= document.getElementById("app_windows");
var mobile= document.getElementById("app_mobile");
mobile.style.display="none";
if(window.innerWidth<1300){
win.style.display="none";


//win.style.visibility="hidden";
//app.style.display=""
}