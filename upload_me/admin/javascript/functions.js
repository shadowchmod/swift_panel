/*
****** DO NOT REMOVE ******
SWIFT Panel Javascript Page (www.SwiftPanel.com)
Copyright @ 2008 All Rights Reserved.
****** DO NOT REMOVE ******
*/

function toggleTab(x)
{
	var n = 1;
	while (n <= numtabs) {
		document.getElementById("tabs"+n).className = "tabs";
		document.getElementById("tab"+n).style.display = "none";
		n++;
	}
	document.getElementById("tabs"+x).className = "tabsactive";
	document.getElementById("tab"+x).style.display = "";
}
function toggleCheckbox(x)
{
	var e = x.elements;
	var n = 1
	while (e.length > n) {
  		if (e[n].type == "checkbox") {
			if (e[n].checked == 1) {
				e[n].checked = 0;
			} else {
				e[n].checked = 1;
			}
		}
		n++;
	}
}
function toggleDropMenu(x)
{
	e = document.getElementById("client"+x);
	if (e.style.display == "none") {
		e.style.display = "";
	} else {
		e.style.display = "none";
	}
}
function toggleOption(x)
{
	e = document.getElementById(x);
	if (e.innerHTML == "Enabled") {
		e.innerHTML = "Disabled";
		e.style.color = "#DD0000";
	} else {
		e.innerHTML = "Enabled";
		e.style.color = "#669933";
	}
}
function jumpMenuGo(objId,targ,restore)
{
  var selObj = null;
  with (document) { 
  	if (getElementById) selObj = getElementById(objId);
  	if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  	if (restore) selObj.selectedIndex=0;
	}
}
function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : "; expires="+exdate.toGMTString());
}