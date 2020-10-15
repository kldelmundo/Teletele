//Last updated June 27th, 07'. Added ability for a DIV to be initially expanded.

var uniquepageid=window.location.href.replace("https://"+window.location.hostname, "").replace(/^\//, "") //get current page path and name, used to uniquely identify this page for persistence feature

//alert(uniquepageid);

function menucollapse(divId, animatetime, persistexpand, initstate){
	this.divId=divId
	this.divObj=document.getElementById(divId)
	this.divObj.style.overflow="hidden"
	this.timelength=animatetime
	this.initstate=(typeof initstate!="undefined" && initstate=="block")? "block" : "contract"
	this.isExpanded=menucollapse.getCookie(uniquepageid+"-"+divId) //"yes" or "no", based on cookie value
	this.contentheight=parseInt(this.divObj.style.height)
	var thisobj=this
	if (isNaN(this.contentheight)){ //if no CSS "height" attribute explicitly defined, get DIV's height on window.load
		menucollapse.dotask(window, function(){thisobj._getheight(persistexpand)}, "load")
		if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes") //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
			this.divObj.style.visibility="hidden" //hide content (versus collapse) until we can get its height
	}
	else if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes") //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
		this.divObj.style.height=0 //just collapse content if CSS "height" attribute available
	if (persistexpand)
		menucollapse.dotask(window, function(){menucollapse.setCookie(uniquepageid+"-"+thisobj.divId, thisobj.isExpanded)}, "unload")
}

menucollapse.prototype._getheight=function(persistexpand){
	this.contentheight=this.divObj.offsetHeight
	if (!persistexpand && this.initstate=="contract" || persistexpand && this.isExpanded!="yes"){ //Hide DIV (unless div should be expanded by default, OR persistence is enabled and this DIV should be expanded)
		this.divObj.style.height=0 //collapse content
		this.divObj.style.visibility="visible"
	}
	else //else if persistence is enabled AND this content should be expanded, define its CSS height value so slideup() has something to work with
		this.divObj.style.height=this.contentheight+"px"
}


menucollapse.prototype._slideengine=function(direction){
	var elapsed=new Date().getTime()-this.startTime //get time animation has run
	var thisobj=this
	if (elapsed<this.timelength){ //if time run is less than specified length
		var distancepercent=(direction=="down")? menucollapse.curveincrement(elapsed/this.timelength) : 1-menucollapse.curveincrement(elapsed/this.timelength)
	this.divObj.style.height=distancepercent * this.contentheight +"px"
	this.runtimer=setTimeout(function(){thisobj._slideengine(direction)}, 10)
	}
	else{ //if animation finished
		this.divObj.style.height=(direction=="down")? this.contentheight+"px" : 0
		this.isExpanded=(direction=="down")? "yes" : "no" //remember whether content is expanded or not
		this.runtimer=null
	}
}


menucollapse.prototype.slidedown=function(){
	if (typeof this.runtimer=="undefined" || this.runtimer==null){ //if animation isn't already running or has stopped running
		if (isNaN(this.contentheight)) //if content height not available yet (until window.onload)
			alert("Please wait until document has fully loaded then click again")
		else if (parseInt(this.divObj.style.height)==0){ //if content is collapsed
			this.startTime=new Date().getTime() //Set animation start time
			this._slideengine("down")
		}
	}
}

menucollapse.prototype.slideup=function(){
	if (typeof this.runtimer=="undefined" || this.runtimer==null){ //if animation isn't already running or has stopped running
		if (isNaN(this.contentheight)) //if content height not available yet (until window.onload)
			alert("Please wait until document has fully loaded then click again")
		else if (parseInt(this.divObj.style.height)==this.contentheight){ //if content is expanded
			this.startTime=new Date().getTime()
			this._slideengine("up")
		}
	}
}

menucollapse.prototype.slideit=function(){
	if (isNaN(this.contentheight)) //if content height not available yet (until window.onload)
		alert("Please wait until document has fully loaded then click again")
	else if (parseInt(this.divObj.style.height)==0)
		this.slidedown()
	else if (parseInt(this.divObj.style.height)==this.contentheight)
		this.slideup()
}

// -------------------------------------------------------------------
// A few utility functions below:
// -------------------------------------------------------------------

menucollapse.curveincrement=function(percent){
	return (1-Math.cos(percent*Math.PI)) / 2 //return cos curve based value from a percentage input
}


menucollapse.dotask=function(target, functionref, tasktype){ //assign a function to execute to an event handler (ie: onunload)
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
}

menucollapse.getCookie=function(Name){ 
	var re=new RegExp(Name+"=[^;]+", "i"); //construct RE to search for target name/value pair
	if (document.cookie.match(re)) //if cookie found
		return document.cookie.match(re)[0].split("=")[1] //return its value
	return ""
}

menucollapse.setCookie=function(name, value, days){
	if (typeof days!="undefined"){ //if set persistent cookie
		var expireDate = new Date()
		var expstring=expireDate.setDate(expireDate.getDate()+days)
		document.cookie = name+"="+value+"; expires="+expireDate.toGMTString()
	}
	else //else if this is a session only cookie
		document.cookie = name+"="+value
}

// -------------------------------------------------------------------
// FUNCTION TO SHOW CONTENTS
// -------------------------------------------------------------------

function showContent(content)	{
	var contentObject = document.getElementById(content);
	var ContentContainer = document.getElementById("DisplayContainer");
	var ContentHolding = document.getElementById("HoldingContainer");
	while(ContentContainer.firstChild) {
		ContentHolding.appendChild(ContentContainer.firstChild);
	}
	ContentContainer.appendChild(contentObject);
}

// -------------------------------------------------------------------
// FUNCTION fOR FACILITIES CONTENT
// -------------------------------------------------------------------

//If using image buttons as controls, Set image buttons' image preload here true
//(use false for no preloading and for when using no image buttons as controls):
var preload_ctrl_images=true;

//And configure the image buttons' images here:
var previmg='left.gif';
var stopimg='stop.gif';
var playimg='play.gif';
var nextimg='right.gif';

var slides=[]; //FIRST SLIDESHOW FOR ARLEGUI
//configure the below images and descriptions to your own. 
slides[0] = ["events/General A/7th_ga/7th_GAa.JPG", ""];
slides[1] = ["events/General A/7th_ga/7th_GAb.JPG", ""];
slides[2] = ["events/General A/7th_ga/7th_GAc.JPG", ""];
slides[3] = ["events/General A/7th_ga/7th_GAd.JPG", ""];
slides[4] = ["events/General A/7th_ga/7th_GAe.JPG", ""];
slides[5] = ["events/General A/7th_ga/7thGA_a.JPG", ""];
slides[6] = ["events/General A/7th_ga/7thGA_b.JPG", ""];
slides[7] = ["events/General A/7th_ga/7thGA_c.JPG", ""];
slides[8] = ["events/General A/7th_ga/7thGA_d.JPG", ""];
slides[9] = ["events/General A/7th_ga/7thGA_e.JPG", ""];
slides[10] = ["events/General A/7th_ga/7thGA_f.JPG", ""];
slides[11] = ["events/General A/7th_ga/7thGA_g.JPG", ""];
slides[12] = ["events/General A/7th_ga/7thGA_h.JPG", ""];
slides[13] = ["events/General A/7th_ga/7thGA_i.JPG", ""];
slides[14] = ["events/General A/7th_ga/7thGA_j.JPG", ""];
slides[15] = ["events/General A/7th_ga/7thGA_k.JPG", ""];
slides[16] = ["events/General A/7th_ga/7thGA_l.JPG", ""];
slides[17] = ["events/General A/7th_ga/7thGA_m.JPG", ""];
slides[18] = ["events/General A/7th_ga/7thGA_o.JPG", ""];
//above slide show uses only the defaults


var slides4=[]; //FIRST SLIDESHOW FOR QC
//configure the below images and s to your own. 
slides4[0] = ["events/General A/8th_ga/GEDC0037.JPG", ""];
slides4[2] = ["events/General A/8th_ga/GEDC0063.JPG", ""];
slides4[5] = ["events/General A/8th_ga/GEDC0028.JPG", ""];
slides4[1] = ["events/General A/8th_ga/GEDC0034.JPG", ""];
slides4[3] = ["events/General A/8th_ga/GEDC0039.JPG", ""];
slides4[4] = ["events/General A/8th_ga/GEDC0045.JPG", ""];
slides4[6] = ["events/General A/8th_ga/GEDC0065.JPG", ""];
slides4[7] = ["events/General A/8th_ga/GEDC0077.JPG", ""];
slides4[8] = ["events/General A/8th_ga/GEDC0095.JPG", ""];
slides4[9] = ["events/General A/8th_ga/GEDC0105.JPG", ""];
slides4[10] = ["events/General A/8th_ga/GEDC0141.JPG", ""];
slides4[11] = ["events/General A/8th_ga/GEDC0176.JPG", ""];
slides4[12] = ["events/General A/8th_ga/GEDC0178.JPG", ""];
slides4[13] = ["events/General A/8th_ga/GEDC0187.JPG", ""];
slides4[14] = ["events/General A/8th_ga/GEDC0203.JPG", ""];
slides4[15] = ["events/General A/8th_ga/GEDC0208.JPG", ""];
slides4[16] = ["events/General A/8th_ga/GEDC0225.JPG", ""];
slides4[17] = ["events/General A/8th_ga/GEDC0338.JPG", ""];
slides4[18] = ["events/General A/8th_ga/GEDC0339.JPG", ""];

var slides5=[]; //FIRST SLIDESHOW FOR QC
//configure the below images and s to your own. 
slides5[0] = ["events/General A/9th_ga/9th (1).JPG", ""];
slides5[1] = ["events/General A/9th_ga/9th (2).JPG", ""];
slides5[2] = ["events/General A/9th_ga/9th (3).JPG", ""];
slides5[3] = ["events/General A/9th_ga/9th (4).JPG", ""];
slides5[4] = ["events/General A/9th_ga/9th (5).JPG", ""];
slides5[5] = ["events/General A/9th_ga/9th (6).JPG", ""];
slides5[6] = ["events/General A/9th_ga/9th (7).JPG", ""];
slides5[7] = ["events/General A/9th_ga/9th (8).JPG", ""];
slides5[8] = ["events/General A/9th_ga/9th (9).JPG", ""];
slides5[9] = ["events/General A/9th_ga/9th (10).JPG", ""];

var slides13=[]; //FIRST SLIDESHOW FOR QC--> Awards
//configure the below images and s to your own. 
slides13[0] = ["events/General A/10th_ga/1.JPG", ""];
slides13[1] = ["events/General A/10th_ga/2.JPG", ""];
slides13[2] = ["events/General A/10th_ga/3.JPG", ""];
slides13[3] = ["events/General A/10th_ga/4.JPG", ""];
slides13[4] = ["events/General A/10th_ga/5.JPG", ""];
slides13[5] = ["events/General A/10th_ga/6.JPG", ""];
slides13[6] = ["events/General A/10th_ga/7.JPG", ""];
slides13[7] = ["events/General A/10th_ga/8.JPG", ""];
slides13[8] = ["events/General A/10th_ga/9.JPG", ""];
slides13[9] = ["events/General A/10th_ga/10.JPG", ""];
slides13[10] = ["events/General A/10th_ga/11.JPG", ""];
slides13[11] = ["events/General A/10th_ga/12.JPG", ""];
slides13[12] = ["events/General A/10th_ga/13.JPG", ""];
slides13[13] = ["events/General A/10th_ga/14.JPG", ""];
slides13[14] = ["events/General A/10th_ga/15.JPG", ""];
slides13[15] = ["events/General A/10th_ga/16.JPG", ""];
slides13[16] = ["events/General A/10th_ga/17.JPG", ""];
slides13[17] = ["events/General A/10th_ga/18.JPG", ""];
slides13[18] = ["events/General A/10th_ga/19.JPG", ""];
slides13[19] = ["events/General A/10th_ga/20.JPG", ""];
slides13[20] = ["events/General A/10th_ga/21.JPG", ""];
slides13[21] = ["events/General A/10th_ga/22.JPG", ""];
slides13[22] = ["events/General A/10th_ga/23.JPG", ""];
slides13[23] = ["events/General A/10th_ga/24.JPG", ""];
slides13[24] = ["events/General A/10th_ga/25.JPG", ""];
slides13[25] = ["events/General A/10th_ga/26.JPG", ""];
slides13[26] = ["events/General A/10th_ga/27.JPG", ""];
slides13[27] = ["events/General A/10th_ga/28.JPG", ""];
slides13[28] = ["events/General A/10th_ga/29.JPG", ""];
slides13[29] = ["events/General A/10th_ga/30.JPG", ""];
slides13[30] = ["events/General A/10th_ga/31.JPG", ""];
slides13[31] = ["events/General A/10th_ga/32.JPG", ""];
slides13[32] = ["events/General A/10th_ga/33.JPG", ""];
slides13[33] = ["events/General A/10th_ga/34.JPG", ""];
slides13[34] = ["events/General A/10th_ga/35.JPG", ""];
slides13[35] = ["events/General A/10th_ga/36.JPG", ""];
slides13[36] = ["events/General A/10th_ga/37.JPG", ""];
slides13[37] = ["events/General A/10th_ga/38.JPG", ""];
slides13[38] = ["events/General A/10th_ga/39.JPG", ""];
slides13[39] = ["events/General A/10th_ga/40.JPG", ""];
slides13[40] = ["events/General A/10th_ga/41.JPG", ""];
slides13[41] = ["events/General A/10th_ga/42.JPG", ""];
slides13[42] = ["events/General A/10th_ga/43.JPG", ""];
slides13[43] = ["events/General A/10th_ga/44.JPG", ""];
slides13[44] = ["events/General A/10th_ga/45.JPG", ""];
slides13[45] = ["events/General A/10th_ga/46.JPG", ""];
slides13[46] = ["events/General A/10th_ga/47.JPG", ""];
slides13[47] = ["events/General A/10th_ga/48.JPG", ""];
slides13[48] = ["events/General A/10th_ga/49.JPG", ""];
slides13[49] = ["events/General A/10th_ga/50.JPG", ""];
slides13[50] = ["events/General A/10th_ga/51.JPG", ""];
slides13[51] = ["events/General A/10th_ga/52.JPG", ""];
slides13[52] = ["events/General A/10th_ga/53.JPG", ""];
slides13[53] = ["events/General A/10th_ga/54.JPG", ""];
slides13[54] = ["events/General A/10th_ga/55.JPG", ""];
slides13[55] = ["events/General A/10th_ga/56.JPG", ""];
slides13[56] = ["events/General A/10th_ga/57.JPG", ""];
slides13[57] = ["events/General A/10th_ga/58.JPG", ""];
slides13[58] = ["events/General A/10th_ga/59.JPG", ""];
slides13[59] = ["events/General A/10th_ga/60.JPG", ""];
slides13[60] = ["events/General A/10th_ga/61.JPG", ""];
slides13[61] = ["events/General A/10th_ga/62 .JPG", ""];
slides13[62] = ["events/General A/10th_ga/63 .JPG", ""];
slides13[63] = ["events/General A/10th_ga/64 .JPG", ""];
slides13[64] = ["events/General A/10th_ga/65 .JPG", ""];
slides13[65] = ["events/General A/10th_ga/66 .JPG", ""];
slides13[66] = ["events/General A/10th_ga/67 .JPG", ""];
slides13[67] = ["events/General A/10th_ga/68 .JPG", ""];
slides13[68] = ["events/General A/10th_ga/69 .JPG", ""];
slides13[69] = ["events/General A/10th_ga/70 .JPG", ""];
slides13[70] = ["events/General A/10th_ga/71 .JPG", ""];
slides13[71] = ["events/General A/10th_ga/72 .JPG", ""];
slides13[72] = ["events/General A/10th_ga/73 .JPG", ""];
slides13[73] = ["events/General A/10th_ga/74 .JPG", ""];
slides13[74] = ["events/General A/10th_ga/75 .JPG", ""];
slides13[75] = ["events/General A/10th_ga/76 .JPG", ""];
slides13[76] = ["events/General A/10th_ga/77 .JPG", ""];
slides13[77] = ["events/General A/10th_ga/78 .JPG", ""];
slides13[78] = ["events/General A/10th_ga/79 .JPG", ""];
slides13[79] = ["events/General A/10th_ga/80 .JPG", ""];
slides13[80] = ["events/General A/10th_ga/81 .JPG", ""];
slides13[81] = ["events/General A/10th_ga/82 .JPG", ""];
slides13[82] = ["events/General A/10th_ga/83 .JPG", ""];
slides13[83] = ["events/General A/10th_ga/84 .JPG", ""];
slides13[84] = ["events/General A/10th_ga/85 .JPG", ""];
slides13[85] = ["events/General A/10th_ga/86 .JPG", ""];
slides13[86] = ["events/General A/10th_ga/87 .JPG", ""];
slides13[87] = ["events/General A/10th_ga/88 .JPG", ""];
slides13[88] = ["events/General A/10th_ga/89 .JPG", ""];
slides13[89] = ["events/General A/10th_ga/90 .JPG", ""];
slides13[90] = ["events/General A/10th_ga/91 .JPG", ""];
slides13[91] = ["events/General A/10th_ga/92 .JPG", ""];
slides13[92] = ["events/General A/10th_ga/93 .JPG", ""];
slides13[93] = ["events/General A/10th_ga/94 .JPG", ""];
slides13[94] = ["events/General A/10th_ga/95 .JPG", ""];
slides13[95] = ["events/General A/10th_ga/96 .JPG", ""];
slides13[96] = ["events/General A/10th_ga/97 .JPG", ""];
slides13[97] = ["events/General A/10th_ga/98 .JPG", ""];
slides13[98] = ["events/General A/10th_ga/99 .JPG", ""];
slides13[99] = ["events/General A/10th_ga/100 .JPG", ""];
slides13[100] = ["events/General A/10th_ga/101 .JPG", ""];
slides13[101] = ["events/General A/10th_ga/102 .JPG", ""];

var slides2=[]; //FIRST SLIDESHOW FOR P. CASAL
//configure the below images and s to your own. 
slides2[0] = ["events/Anniv/35th anniv/35th_ANNIVa.JPG", ""];
slides2[1] = ["events/Anniv/35th anniv/35th_ANNIVb.JPG", ""];
slides2[2] = ["events/Anniv/35th anniv/35th_ANNIVc.JPG", ""];

//above slide show uses only the defaults


var slides3=[]; //FIRST SLIDESHOW FOR QC
//configure the below images and s to your own. 
slides3[0] = ["events/Induction/Induction_2011/INDUCTIONa.JPG", ""];
slides3[1] = ["events/Induction/Induction_2011/INDUCTIONb.JPG", ""];
slides3[2] = ["events/Induction/Induction_2011/INDUCTIONc.JPG", ""];
slides3[3] = ["events/Induction/Induction_2011/INDUCTIONd.JPG", ""];



var slides6=[]; //FIRST SLIDESHOW FOR QC-->MANILA BAY CLEAN UP
//configure the below images and s to your own. 
slides6[0] = ["events/Comm-Social-Activities/MBCleanUp/1.JPG", ""];
slides6[1] = ["events/Comm-Social-Activities/MBCleanUp/2.JPG", ""];
slides6[2] = ["events/Comm-Social-Activities/MBCleanUp/3.JPG", ""];
slides6[3] = ["events/Comm-Social-Activities/MBCleanUp/4.JPG", ""];
slides6[4] = ["events/Comm-Social-Activities/MBCleanUp/5.JPG", ""];
slides6[5] = ["events/Comm-Social-Activities/MBCleanUp/6.JPG", ""];
slides6[6] = ["events/Comm-Social-Activities/MBCleanUp/7.JPG", ""];
slides6[7] = ["events/Comm-Social-Activities/MBCleanUp/8.JPG", ""];
slides6[8] = ["events/Comm-Social-Activities/MBCleanUp/9.JPG", ""];
slides6[9] = ["events/Comm-Social-Activities/MBCleanUp/10.JPG", ""];
slides6[10] = ["events/Comm-Social-Activities/MBCleanUp/11.JPG", ""];
slides6[11] = ["events/Comm-Social-Activities/MBCleanUp/12.JPG", ""];
slides6[12] = ["events/Comm-Social-Activities/MBCleanUp/13.JPG", ""];
slides6[13] = ["events/Comm-Social-Activities/MBCleanUp/14.JPG", ""];
slides6[14] = ["events/Comm-Social-Activities/MBCleanUp/15.JPG", ""];

var slides7=[]; //FIRST SLIDESHOW FOR QC--> 36 anniv and induc
//configure the below images and s to your own. 
slides7[0] = ["events/Anniv/37-anniv-induc/1.JPG", ""];
slides7[1] = ["events/Anniv/37-anniv-induc/2.JPG", ""];
slides7[2] = ["events/Anniv/37-anniv-induc/3.JPG", ""];
slides7[3] = ["events/Anniv/37-anniv-induc/4.JPG", ""];
slides7[4] = ["events/Anniv/37-anniv-induc/5.JPG", ""];
slides7[5] = ["events/Anniv/37-anniv-induc/6.JPG", ""];
slides7[6] = ["events/Anniv/37-anniv-induc/7.JPG", ""];
slides7[7] = ["events/Anniv/37-anniv-induc/8.JPG", ""];
slides7[8] = ["events/Anniv/37-anniv-induc/9.JPG", ""];
slides7[9] = ["events/Anniv/37-anniv-induc/10.JPG", ""];
slides7[10] = ["events/Anniv/37-anniv-induc/11.JPG", ""];
slides7[11] = ["events/Anniv/37-anniv-induc/12.JPG", ""];
slides7[12] = ["events/Anniv/37-anniv-induc/13.JPG", ""];
slides7[13] = ["events/Anniv/37-anniv-induc/14.JPG", ""];
slides7[14] = ["events/Anniv/37-anniv-induc/15.JPG", ""];
slides7[15] = ["events/Anniv/37-anniv-induc/16.JPG", ""];
slides7[16] = ["events/Anniv/37-anniv-induc/17.JPG", ""];
slides7[17] = ["events/Anniv/37-anniv-induc/18.JPG", ""];
slides7[18] = ["events/Anniv/37-anniv-induc/19.JPG", ""];
slides7[19] = ["events/Anniv/37-anniv-induc/20.JPG", ""];
slides7[20] = ["events/Anniv/37-anniv-induc/21.JPG", ""];
slides7[21] = ["events/Anniv/37-anniv-induc/22.JPG", ""];
slides7[22] = ["events/Anniv/37-anniv-induc/23.JPG", ""];
slides7[23] = ["events/Anniv/37-anniv-induc/24.JPG", ""];
slides7[24] = ["events/Anniv/37-anniv-induc/25.JPG", ""];
slides7[25] = ["events/Anniv/37-anniv-induc/26.JPG", ""];
slides7[26] = ["events/Anniv/37-anniv-induc/27.JPG", ""];
slides7[27] = ["events/Anniv/37-anniv-induc/28.JPG", ""];
slides7[28] = ["events/Anniv/37-anniv-induc/29.JPG", ""];
slides7[29] = ["events/Anniv/37-anniv-induc/30.JPG", ""];
slides7[30] = ["events/Anniv/37-anniv-induc/31.JPG", ""];
slides7[31] = ["events/Anniv/37-anniv-induc/32.JPG", ""];
slides7[32] = ["events/Anniv/37-anniv-induc/33.JPG", ""];
slides7[33] = ["events/Anniv/37-anniv-induc/34.JPG", ""];
slides7[34] = ["events/Anniv/37-anniv-induc/35.JPG", ""];
slides7[35] = ["events/Anniv/37-anniv-induc/36.JPG", ""];
slides7[36] = ["events/Anniv/37-anniv-induc/37.JPG", ""];
slides7[37] = ["events/Anniv/37-anniv-induc/38.JPG", ""];
slides7[38] = ["events/Anniv/37-anniv-induc/39.JPG", ""];
slides7[39] = ["events/Anniv/37-anniv-induc/40.JPG", ""];
slides7[40] = ["events/Anniv/37-anniv-induc/41.JPG", ""];
//above slide show uses only the defaults

var slides8=[]; //FIRST SLIDESHOW FOR QC--> 36 anniv and induc
//configure the below images and s to your own. 
slides8[0] = ["events/Comm-Social-Activities/Lourdes/1.JPG", ""];
slides8[1] = ["events/Comm-Social-Activities/Lourdes/2.JPG", ""];
slides8[2] = ["events/Comm-Social-Activities/Lourdes/3.JPG", ""];
slides8[3] = ["events/Comm-Social-Activities/Lourdes/4.JPG", ""];
slides8[4] = ["events/Comm-Social-Activities/Lourdes/5.JPG", ""];
slides8[5] = ["events/Comm-Social-Activities/Lourdes/6.JPG", ""];
slides8[6] = ["events/Comm-Social-Activities/Lourdes/7.JPG", ""];
slides8[7] = ["events/Comm-Social-Activities/Lourdes/8.JPG", ""];
slides8[8] = ["events/Comm-Social-Activities/Lourdes/9.JPG", ""];
slides8[9] = ["events/Comm-Social-Activities/Lourdes/10.JPG", ""];
slides8[10] = ["events/Comm-Social-Activities/Lourdes/11.JPG", ""];
slides8[11] = ["events/Comm-Social-Activities/Lourdes/12.JPG", ""];
slides8[12] = ["events/Comm-Social-Activities/Lourdes/13.JPG", ""];
slides8[13] = ["events/Comm-Social-Activities/Lourdes/14.JPG", ""];
slides8[14] = ["events/Comm-Social-Activities/Lourdes/15.JPG", ""];
slides8[15] = ["events/Comm-Social-Activities/Lourdes/16.JPG", ""];
slides8[16] = ["events/Comm-Social-Activities/Lourdes/17.JPG", ""];
slides8[17] = ["events/Comm-Social-Activities/Lourdes/18.JPG", ""];
slides8[18] = ["events/Comm-Social-Activities/Lourdes/19.JPG", ""];
slides8[19] = ["events/Comm-Social-Activities/Lourdes/20.JPG", ""];
slides8[20] = ["events/Comm-Social-Activities/Lourdes/21.JPG", ""];
slides8[21] = ["events/Comm-Social-Activities/Lourdes/22.JPG", ""];
slides8[22] = ["events/Comm-Social-Activities/Lourdes/23.JPG", ""];
slides8[23] = ["events/Comm-Social-Activities/Lourdes/24.JPG", ""];
slides8[24] = ["events/Comm-Social-Activities/Lourdes/25.JPG", ""];
slides8[25] = ["events/Comm-Social-Activities/Lourdes/26.JPG", ""];
slides8[26] = ["events/Comm-Social-Activities/Lourdes/27.JPG", ""];
slides8[27] = ["events/Comm-Social-Activities/Lourdes/28.JPG", ""];
//above slide show uses only the defaults

var slides9=[]; //FIRST SLIDESHOW FOR QC--> awards
//configure the below images and s to your own. 
slides9[0] = ["events/Awards/koop bida/1.JPG", ""];
slides9[1] = ["events/Awards/koop bida/2.JPG", ""];
slides9[2] = ["events/Awards/koop bida/3.JPG", ""];
slides9[3] = ["events/Awards/koop bida/4.JPG", ""];
slides9[4] = ["events/Awards/koop bida/5.JPG", ""];
slides9[5] = ["events/Awards/koop bida/6.JPG", ""];
slides9[6] = ["events/Awards/koop bida/7.JPG", ""];
slides9[7] = ["events/Awards/koop bida/8.JPG", ""];
slides9[8] = ["events/Awards/koop bida/9.JPG", ""];
slides9[9] = ["events/Awards/koop bida/10.JPG", ""];
slides9[10] = ["events/Awards/koop bida/11.JPG", ""];
slides9[11] = ["events/Awards/koop bida/12.JPG", ""];
slides9[12] = ["events/Awards/koop bida/13.JPG", ""];
slides9[13] = ["events/Awards/koop bida/14.JPG", ""];
slides9[14] = ["events/Awards/koop bida/15.JPG", ""];
slides9[15] = ["events/Awards/koop bida/16.JPG", ""];
//above slide show uses only the defaults

var slides10=[]; //FIRST SLIDESHOW FOR QC--> Awards
//configure the below images and s to your own. 
slides10[0] = ["events/Induction/Induction_2012/1.JPG", ""];
slides10[1] = ["events/Induction/Induction_2012/2.JPG", ""];
slides10[2] = ["events/Induction/Induction_2012/3.JPG", ""];
slides10[3] = ["events/Induction/Induction_2012/4.JPG", ""];
slides10[4] = ["events/Induction/Induction_2012/5.JPG", ""];
slides10[5] = ["events/Induction/Induction_2012/6.JPG", ""];
slides10[6] = ["events/Induction/Induction_2012/7.JPG", ""];
slides10[7] = ["events/Induction/Induction_2012/8.JPG", ""];
slides10[8] = ["events/Induction/Induction_2012/9.JPG", ""];
slides10[9] = ["events/Induction/Induction_2012/10.JPG", ""];
slides10[10] = ["events/Induction/Induction_2012/11.JPG", ""];
slides10[11] = ["events/Induction/Induction_2012/12.JPG", ""];
slides10[12] = ["events/Induction/Induction_2012/13.JPG", ""];
slides10[13] = ["events/Induction/Induction_2012/14.JPG", ""];
slides10[14] = ["events/Induction/Induction_2012/15.JPG", ""];
slides10[15] = ["events/Induction/Induction_2012/16.JPG", ""];
slides10[16] = ["events/Induction/Induction_2012/17.JPG", ""];
slides10[17] = ["events/Induction/Induction_2012/18.JPG", ""];
slides10[18] = ["events/Induction/Induction_2012/19.JPG", ""];
slides10[19] = ["events/Induction/Induction_2012/20.JPG", ""];
slides10[20] = ["events/Induction/Induction_2012/21.JPG", ""];
slides10[21] = ["events/Induction/Induction_2012/22.JPG", ""];
slides10[22] = ["events/Induction/Induction_2012/23.JPG", ""];
slides10[23] = ["events/Induction/Induction_2012/24.JPG", ""];
slides10[24] = ["events/Induction/Induction_2012/25.JPG", ""];
slides10[25] = ["events/Induction/Induction_2012/26.JPG", ""];
slides10[26] = ["events/Induction/Induction_2012/27.JPG", ""];
slides10[27] = ["events/Induction/Induction_2012/28.JPG", ""];
slides10[28] = ["events/Induction/Induction_2012/29.JPG", ""];
slides10[29] = ["events/Induction/Induction_2012/30.JPG", ""];
slides10[30] = ["events/Induction/Induction_2012/31.JPG", ""];
slides10[31] = ["events/Induction/Induction_2012/32.JPG", ""];
slides10[32] = ["events/Induction/Induction_2012/33.JPG", ""];
slides10[33] = ["events/Induction/Induction_2012/34.JPG", ""];
slides10[34] = ["events/Induction/Induction_2012/35.JPG", ""];
slides10[35] = ["events/Induction/Induction_2012/36.JPG", ""];
slides10[36] = ["events/Induction/Induction_2012/37.JPG", ""];
slides10[37] = ["events/Induction/Induction_2012/38.JPG", ""];
slides10[38] = ["events/Induction/Induction_2012/39.JPG", ""];
slides10[39] = ["events/Induction/Induction_2012/40.JPG", ""];
slides10[40] = ["events/Induction/Induction_2012/41.JPG", ""];
slides10[41] = ["events/Induction/Induction_2012/42.JPG", ""];
slides10[42] = ["events/Induction/Induction_2012/43.JPG", ""];
slides10[43] = ["events/Induction/Induction_2012/44.JPG", ""];
slides10[44] = ["events/Induction/Induction_2012/45.JPG", ""];
slides10[45] = ["events/Induction/Induction_2012/46.JPG", ""];
slides10[46] = ["events/Induction/Induction_2012/47.JPG", ""];
slides10[47] = ["events/Induction/Induction_2012/48.JPG", ""];
slides10[48] = ["events/Induction/Induction_2012/49.JPG", ""];
slides10[49] = ["events/Induction/Induction_2012/50.JPG", ""];
slides10[50] = ["events/Induction/Induction_2012/51.JPG", ""];
slides10[51] = ["events/Induction/Induction_2012/52.JPG", ""];
slides10[52] = ["events/Induction/Induction_2012/53.JPG", ""];
slides10[53] = ["events/Induction/Induction_2012/54.JPG", ""];
slides10[54] = ["events/Induction/Induction_2012/55.JPG", ""];
slides10[55] = ["events/Induction/Induction_2012/56.JPG", ""];
slides10[56] = ["events/Induction/Induction_2012/57.JPG", ""];
slides10[57] = ["events/Induction/Induction_2012/58.JPG", ""];
slides10[58] = ["events/Induction/Induction_2012/59.JPG", ""];
slides10[59] = ["events/Induction/Induction_2012/60.JPG", ""];
slides10[60] = ["events/Induction/Induction_2012/61.JPG", ""];
slides10[61] = ["events/Induction/Induction_2012/62 .JPG", ""];

var slides11=[]; //FIRST SLIDESHOW FOR QC--> 36 anniv and induc
//configure the below images and s to your own. 
slides11[0] = ["events/Awards/Dela Salle/14.JPG", ""];
slides11[1] = ["events/Awards/Dela Salle/15.JPG", ""];
slides11[2] = ["events/Awards/Dela Salle/16.JPG", ""];
slides11[3] = ["events/Awards/Dela Salle/4.JPG", ""];
slides11[4] = ["events/Awards/Dela Salle/5.JPG", ""];
slides11[5] = ["events/Awards/Dela Salle/6.JPG", ""];
slides11[6] = ["events/Awards/Dela Salle/7.JPG", ""];
slides11[7] = ["events/Awards/Dela Salle/8.JPG", ""];
slides11[8] = ["events/Awards/Dela Salle/9.JPG", ""];
slides11[9] = ["events/Awards/Dela Salle/10.JPG", ""];
slides11[10] = ["events/Awards/Dela Salle/11.JPG", ""];
slides11[11] = ["events/Awards/Dela Salle/12.JPG", ""];
slides11[12] = ["events/Awards/Dela Salle/13.JPG", ""];
slides11[13] = ["events/Awards/Dela Salle/1.JPG", ""];
slides11[14] = ["events/Awards/Dela Salle/2.JPG", ""];
slides11[15] = ["events/Awards/Dela Salle/3.JPG", ""];
slides11[16] = ["events/Awards/Dela Salle/17.JPG", ""];
slides11[17] = ["events/Awards/Dela Salle/18.JPG", ""];
slides11[18] = ["events/Awards/Dela Salle/19.JPG", ""];
slides11[19] = ["events/Awards/Dela Salle/20.JPG", ""];
slides11[20] = ["events/Awards/Dela Salle/21.JPG", ""];
slides11[21] = ["events/Awards/Dela Salle/22.JPG", ""];
slides11[22] = ["events/Awards/Dela Salle/23.JPG", ""];
slides11[23] = ["events/Awards/Dela Salle/24.JPG", ""];
slides11[24] = ["events/Awards/Dela Salle/25.JPG", ""];
slides11[25] = ["events/Awards/Dela Salle/26.JPG", ""];
slides11[26] = ["events/Awards/Dela Salle/27.JPG", ""];
slides11[27] = ["events/Awards/Dela Salle/28.JPG", ""];
slides11[27] = ["events/Awards/Dela Salle/29.JPG", ""];
slides11[27] = ["events/Awards/Dela Salle/30.JPG", ""];
//above slide show uses only the defaults

var slides12=[]; //FIRST SLIDESHOW FOR QC--> 36th Anniversary
//configure the below images and s to your own. 
slides12[0] = ["events/Anniv/36th anniv/1.JPG", ""];
slides12[1] = ["events/Anniv/36th anniv/2.JPG", ""];
slides12[2] = ["events/Anniv/36th anniv/3.JPG", ""];
slides12[3] = ["events/Anniv/36th anniv/4.JPG", ""];
slides12[4] = ["events/Anniv/36th anniv/5.JPG", ""];
slides12[5] = ["events/Anniv/36th anniv/6.JPG", ""];
slides12[6] = ["events/Anniv/36th anniv/7.JPG", ""];
slides12[7] = ["events/Anniv/36th anniv/8.JPG", ""];
slides12[8] = ["events/Anniv/36th anniv/9.JPG", ""];




var slides14=[]; //FIRST SLIDESHOW FOR QC--> Awards
//configure the below images and s to your own. 
slides14[0] = ["events/Induction/Induction_2014/1.JPG", ""];
slides14[1] = ["events/Induction/Induction_2014/2.JPG", ""];
slides14[2] = ["events/Induction/Induction_2014/3.JPG", ""];
slides14[3] = ["events/Induction/Induction_2014/4.JPG", ""];
slides14[4] = ["events/Induction/Induction_2014/5.JPG", ""];
slides14[5] = ["events/Induction/Induction_2014/6.JPG", ""];
slides14[6] = ["events/Induction/Induction_2014/7.JPG", ""];
slides14[7] = ["events/Induction/Induction_2014/8.JPG", ""];
slides14[8] = ["events/Induction/Induction_2014/9.JPG", ""];
slides14[9] = ["events/Induction/Induction_2014/10.JPG", ""];
slides14[10] = ["events/Induction/Induction_2014/11.JPG", ""];
slides14[11] = ["events/Induction/Induction_2014/12.JPG", ""];
slides14[12] = ["events/Induction/Induction_2014/13.JPG", ""];
slides14[13] = ["events/Induction/Induction_2014/14.JPG", ""];
slides14[14] = ["events/Induction/Induction_2014/15.JPG", ""];
slides14[15] = ["events/Induction/Induction_2014/16.JPG", ""];
slides14[16] = ["events/Induction/Induction_2014/17.JPG", ""];
slides14[17] = ["events/Induction/Induction_2014/18.JPG", ""];
slides14[18] = ["events/Induction/Induction_2014/19.JPG", ""];
slides14[19] = ["events/Induction/Induction_2014/20.JPG", ""];
slides14[20] = ["events/Induction/Induction_2014/21.JPG", ""];
slides14[21] = ["events/Induction/Induction_2014/22.JPG", ""];
slides14[22] = ["events/Induction/Induction_2014/23.JPG", ""];
slides14[23] = ["events/Induction/Induction_2014/24.JPG", ""];
slides14[24] = ["events/Induction/Induction_2014/25.JPG", ""];
slides14[25] = ["events/Induction/Induction_2014/26.JPG", ""];
slides14[26] = ["events/Induction/Induction_2014/27.JPG", ""];
slides14[27] = ["events/Induction/Induction_2014/28.JPG", ""];
slides14[28] = ["events/Induction/Induction_2014/29.JPG", ""];
slides14[29] = ["events/Induction/Induction_2014/30.JPG", ""];
slides14[30] = ["events/Induction/Induction_2014/31.JPG", ""];
slides14[31] = ["events/Induction/Induction_2014/32.JPG", ""];
slides14[32] = ["events/Induction/Induction_2014/33.JPG", ""];
slides14[33] = ["events/Induction/Induction_2014/34.JPG", ""];
slides14[34] = ["events/Induction/Induction_2014/35.JPG", ""];
slides14[35] = ["events/Induction/Induction_2014/36.JPG", ""];
slides14[36] = ["events/Induction/Induction_2014/37.JPG", ""];
slides14[37] = ["events/Induction/Induction_2014/38.JPG", ""];
slides14[38] = ["events/Induction/Induction_2014/39.JPG", ""];
slides14[39] = ["events/Induction/Induction_2014/40.JPG", ""];
slides14[40] = ["events/Induction/Induction_2014/41.JPG", ""];
slides14[41] = ["events/Induction/Induction_2014/42.JPG", ""];
slides14[42] = ["events/Induction/Induction_2014/43.JPG", ""];
slides14[43] = ["events/Induction/Induction_2014/44.JPG", ""];
slides14[44] = ["events/Induction/Induction_2014/45.JPG", ""];
slides14[45] = ["events/Induction/Induction_2014/46.JPG", ""];
slides14[46] = ["events/Induction/Induction_2014/47.JPG", ""];
slides14[47] = ["events/Induction/Induction_2014/48.JPG", ""];
slides14[48] = ["events/Induction/Induction_2014/49.JPG", ""];
slides14[49] = ["events/Induction/Induction_2014/50.JPG", ""];
slides14[50] = ["events/Induction/Induction_2014/51.JPG", ""];
slides14[51] = ["events/Induction/Induction_2014/52.JPG", ""];
slides14[52] = ["events/Induction/Induction_2014/53.JPG", ""];
slides14[53] = ["events/Induction/Induction_2014/54.JPG", ""];
slides14[54] = ["events/Induction/Induction_2014/55.JPG", ""];
slides14[55] = ["events/Induction/Induction_2014/56.JPG", ""];
slides14[56] = ["events/Induction/Induction_2014/57.JPG", ""];
slides14[57] = ["events/Induction/Induction_2014/58.JPG", ""];
slides14[58] = ["events/Induction/Induction_2014/59.JPG", ""];
slides14[59] = ["events/Induction/Induction_2014/60.JPG", ""];
slides14[60] = ["events/Induction/Induction_2014/61.JPG", ""];
slides14[61] = ["events/Induction/Induction_2014/62 .JPG", ""];
slides14[62] = ["events/Induction/Induction_2014/63 .JPG", ""];
slides14[63] = ["events/Induction/Induction_2014/64 .JPG", ""];
slides14[64] = ["events/Induction/Induction_2014/65 .JPG", ""];
slides14[65] = ["events/Induction/Induction_2014/66 .JPG", ""];
slides14[66] = ["events/Induction/Induction_2014/67 .JPG", ""];
slides14[67] = ["events/Induction/Induction_2014/68 .JPG", ""];
slides14[68] = ["events/Induction/Induction_2014/69 .JPG", ""];

var slides15=[]; //FIRST SLIDESHOW FOR QC-->MANILA BAY CLEAN UP
//configure the below images and s to your own. 
slides15[0] = ["events/Comm-Social-Activities/MBCleanUpRun/1.JPG", ""];
slides15[1] = ["events/Comm-Social-Activities/MBCleanUpRun/2.JPG", ""];
slides15[2] = ["events/Comm-Social-Activities/MBCleanUpRun/3.JPG", ""];
slides15[3] = ["events/Comm-Social-Activities/MBCleanUpRun/4.JPG", ""];
slides15[4] = ["events/Comm-Social-Activities/MBCleanUpRun/5.JPG", ""];
slides15[5] = ["events/Comm-Social-Activities/MBCleanUpRun/6.JPG", ""];
slides15[6] = ["events/Comm-Social-Activities/MBCleanUpRun/7.JPG", ""];
slides15[7] = ["events/Comm-Social-Activities/MBCleanUpRun/8.JPG", ""];
slides15[8] = ["events/Comm-Social-Activities/MBCleanUpRun/9.JPG", ""];
slides15[9] = ["events/Comm-Social-Activities/MBCleanUpRun/10.JPG", ""];
slides15[10] = ["events/Comm-Social-Activities/MBCleanUpRun/11.JPG", ""];
slides15[11] = ["events/Comm-Social-Activities/MBCleanUpRun/12.JPG", ""];
slides15[12] = ["events/Comm-Social-Activities/MBCleanUpRun/13.JPG", ""];
slides15[13] = ["events/Comm-Social-Activities/MBCleanUpRun/14.JPG", ""];
slides15[14] = ["events/Comm-Social-Activities/MBCleanUpRun/15.JPG", ""];
slides15[15] = ["events/Comm-Social-Activities/MBCleanUpRun/16.JPG", ""];
slides15[16] = ["events/Comm-Social-Activities/MBCleanUpRun/17.JPG", ""];
slides15[17] = ["events/Comm-Social-Activities/MBCleanUpRun/18.JPG", ""];
slides15[18] = ["events/Comm-Social-Activities/MBCleanUpRun/19.JPG", ""];
slides15[19] = ["events/Comm-Social-Activities/MBCleanUpRun/20.JPG", ""];
slides15[20] = ["events/Comm-Social-Activities/MBCleanUpRun/21.JPG", ""];
slides15[21] = ["events/Comm-Social-Activities/MBCleanUpRun/22.JPG", ""];
slides15[22] = ["events/Comm-Social-Activities/MBCleanUpRun/23.JPG", ""];
slides15[23] = ["events/Comm-Social-Activities/MBCleanUpRun/24.JPG", ""];
slides15[24] = ["events/Comm-Social-Activities/MBCleanUpRun/25.JPG", ""];
slides15[25] = ["events/Comm-Social-Activities/MBCleanUpRun/26.JPG", ""];
slides15[26] = ["events/Comm-Social-Activities/MBCleanUpRun/27.JPG", ""];
slides15[27] = ["events/Comm-Social-Activities/MBCleanUpRun/28.JPG", ""];
slides15[28] = ["events/Comm-Social-Activities/MBCleanUpRun/29.JPG", ""];
slides15[29] = ["events/Comm-Social-Activities/MBCleanUpRun/30.JPG", ""];

var slides16=[]; //FIRST SLIDESHOW FOR QC-->MANILA BAY CLEAN UP
//configure the below images and s to your own. 
slides16[0] = ["events/Comm-Social-Activities/MBCleanUp2014/1.JPG", ""];
slides16[1] = ["events/Comm-Social-Activities/MBCleanUp2014/2.JPG", ""];
slides16[2] = ["events/Comm-Social-Activities/MBCleanUp2014/3.JPG", ""];
slides16[3] = ["events/Comm-Social-Activities/MBCleanUp2014/4.JPG", ""];
slides16[4] = ["events/Comm-Social-Activities/MBCleanUp2014/5.JPG", ""];
slides16[5] = ["events/Comm-Social-Activities/MBCleanUp2014/6.JPG", ""];
slides16[6] = ["events/Comm-Social-Activities/MBCleanUp2014/7.JPG", ""];
slides16[7] = ["events/Comm-Social-Activities/MBCleanUp2014/8.JPG", ""];
slides16[8] = ["events/Comm-Social-Activities/MBCleanUp2014/9.JPG", ""];
slides16[9] = ["events/Comm-Social-Activities/MBCleanUp2014/10.JPG", ""];
slides16[10] = ["events/Comm-Social-Activities/MBCleanUp2014/11.JPG", ""];
slides16[11] = ["events/Comm-Social-Activities/MBCleanUp2014/12.JPG", ""];
slides16[12] = ["events/Comm-Social-Activities/MBCleanUp2014/13.JPG", ""];
slides16[13] = ["events/Comm-Social-Activities/MBCleanUp2014/14.JPG", ""];
slides16[14] = ["events/Comm-Social-Activities/MBCleanUp2014/15.JPG", ""];
slides16[15] = ["events/Comm-Social-Activities/MBCleanUp2014/16.JPG", ""];
slides16[16] = ["events/Comm-Social-Activities/MBCleanUp2014/17.JPG", ""];

var slides17=[];//12th_ga
//configure the below images and s to your own. 
slides17[0] = ["events/General A/12th_ga/1.jpg", ""];
slides17[1] = ["events/General A/12th_ga/2.jpg", ""];
slides17[2] = ["events/General A/12th_ga/3.jpg", ""];
slides17[3] = ["events/General A/12th_ga/4.jpg", ""];
slides17[4] = ["events/General A/12th_ga/5.jpg", ""];
slides17[5] = ["events/General A/12th_ga/6.jpg", ""];
slides17[6] = ["events/General A/12th_ga/7.jpg", ""];
slides17[7] = ["events/General A/12th_ga/8.jpg", ""];
slides17[8] = ["events/General A/12th_ga/9.jpg", ""];
slides17[9] = ["events/General A/12th_ga/10.jpg", ""];
slides17[10] = ["events/General A/12th_ga/11.jpg", ""];
slides17[11] = ["events/General A/12th_ga/12.jpg", ""];
slides17[12] = ["events/General A/12th_ga/13.jpg", ""];
slides17[13] = ["events/General A/12th_ga/14.jpg", ""];
slides17[14] = ["events/General A/12th_ga/15.jpg", ""];
slides17[15] = ["events/General A/12th_ga/16.jpg", ""];
slides17[16] = ["events/General A/12th_ga/17.jpg", ""];
slides17[17] = ["events/General A/12th_ga/18.jpg", ""];
slides17[18] = ["events/General A/12th_ga/19.jpg", ""];
slides17[19] = ["events/General A/12th_ga/20.jpg", ""];


var slides18=[];//13th_ga
//configure the below images and s to your own. 
slides18[0] = ["events/General A/13th_ga/1.jpg", ""];
slides18[1] = ["events/General A/13th_ga/2.jpg", ""];
slides18[2] = ["events/General A/13th_ga/3.jpg", ""];
slides18[3] = ["events/General A/13th_ga/4.jpg", ""];
slides18[4] = ["events/General A/13th_ga/5.jpg", ""];
slides18[5] = ["events/General A/13th_ga/6.jpg", ""];
slides18[6] = ["events/General A/13th_ga/7.jpg", ""];
slides18[7] = ["events/General A/13th_ga/8.jpg", ""];
slides18[8] = ["events/General A/13th_ga/9.jpg", ""];
slides18[9] = ["events/General A/13th_ga/10.jpg", ""];
slides18[10] = ["events/General A/13th_ga/11.jpg", ""];
slides18[11] = ["events/General A/13th_ga/12.jpg", ""];
slides18[12] = ["events/General A/13th_ga/13.jpg", ""];
slides18[13] = ["events/General A/13th_ga/14.jpg", ""];
slides18[14] = ["events/General A/13th_ga/15.jpg", ""];
slides18[15] = ["events/General A/13th_ga/16.jpg", ""];
slides18[16] = ["events/General A/13th_ga/17.jpg", ""];
slides18[17] = ["events/General A/13th_ga/18.jpg", ""];
slides18[18] = ["events/General A/13th_ga/19.jpg", ""];
slides18[19] = ["events/General A/13th_ga/20.jpg", ""];

var slides19=[];//induction_2016
//configure the below images and s to your own. 
slides19[0] = ["events/Induction/Induction_2016/1.jpg", ""];
slides19[1] = ["events/Induction/Induction_2016/2.jpg", ""];
slides19[2] = ["events/Induction/Induction_2016/3.jpg", ""];
slides19[3] = ["events/Induction/Induction_2016/4.jpg", ""];
slides19[4] = ["events/Induction/Induction_2016/5.jpg", ""];
slides19[5] = ["events/Induction/Induction_2016/6.jpg", ""];

var slides20=[];//induction_2017
//configure the below images and s to your own. 
slides20[0] = ["events/Induction/Induction_2017/1.jpg", ""];
slides20[1] = ["events/Induction/Induction_2017/2.jpg", ""];
slides20[2] = ["events/Induction/Induction_2017/3.jpg", ""];
slides20[3] = ["events/Induction/Induction_2017/4.jpg", ""];
slides20[4] = ["events/Induction/Induction_2017/5.jpg", ""];
slides20[5] = ["events/Induction/Induction_2017/6.jpg", ""];
slides20[6] = ["events/Induction/Induction_2017/7.jpg", ""];
slides20[7] = ["events/Induction/Induction_2017/8.jpg", ""];
slides20[8] = ["events/Induction/Induction_2017/9.jpg", ""];
slides20[9] = ["events/Induction/Induction_2017/10.jpg", ""];
slides20[10] = ["events/Induction/Induction_2017/11.jpg", ""];
slides20[11] = ["events/Induction/Induction_2017/12.jpg", ""];
slides20[12] = ["events/Induction/Induction_2017/13.jpg", ""];
slides20[13] = ["events/Induction/Induction_2017/14.jpg", ""];
slides20[14] = ["events/Induction/Induction_2017/15.jpg", ""];
slides20[15] = ["events/Induction/Induction_2017/16.jpg", ""];
slides20[16] = ["events/Induction/Induction_2017/17.jpg", ""];
slides20[17] = ["events/Induction/Induction_2017/18.jpg", ""];
slides20[18] = ["events/Induction/Induction_2017/19.jpg", ""];
slides20[19] = ["events/Induction/Induction_2017/20.jpg", ""];

var slides21=[];//41Th anniversary 2017
//configure the below images and s to your own. 
slides21[0] = ["events/Anniv/41th anniv/1.jpg", ""];
slides21[1] = ["events/Anniv/41th anniv/2.jpg", ""];
slides21[2] = ["events/Anniv/41th anniv/3.jpg", ""];
slides21[3] = ["events/Anniv/41th anniv/4.jpg", ""];
slides21[4] = ["events/Anniv/41th anniv/5.jpg", ""];
slides21[5] = ["events/Anniv/41th anniv/6.jpg", ""];
slides21[6] = ["events/Anniv/41th anniv/7.jpg", ""];
slides21[7] = ["events/Anniv/41th anniv/8.jpg", ""];
slides21[8] = ["events/Anniv/41th anniv/9.jpg", ""];
slides21[9] = ["events/Anniv/41th anniv/10.jpg", ""];
slides21[10] = ["events/Anniv/41th anniv/11.jpg", ""];
slides21[11] = ["events/Anniv/41th anniv/12.jpg", ""];
slides21[12] = ["events/Anniv/41th anniv/13.jpg", ""];
slides21[13] = ["events/Anniv/41th anniv/14.jpg", ""];
slides21[14] = ["events/Anniv/41th anniv/15.jpg", ""];
slides21[15] = ["events/Anniv/41th anniv/16.jpg", ""];
slides21[16] = ["events/Anniv/41th anniv/17.jpg", ""];
slides21[17] = ["events/Anniv/41th anniv/18.jpg", ""];
slides21[18] = ["events/Anniv/41th anniv/19.jpg", ""];
slides21[19] = ["events/Anniv/41th anniv/20.jpg", ""];

var slides22=[];//40th Anniversary 2016
//configure the below images and s to your own. 
slides22[0] = ["events/Anniv/40th anniv/1.jpg", ""];
slides22[1] = ["events/Anniv/40th anniv/2.jpg", ""];
slides22[2] = ["events/Anniv/40th anniv/3.jpg", ""];





