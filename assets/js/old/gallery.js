// Gallery Script

/**
* addLoadEvent function
*
* adds a function to the events that are called on page load
*/
function addLoadEvent(func)
{	
	if (typeof window.onload != 'function')
	{
		window.onload = func;
	}
	else
	{
		var oldOnLoad = window.onload;
		window.onload = function() 
		{
			oldOnLoad();
			func();
		}
	}
}

//Declare global variables
var fadeTimer, moveInterval, thumbPosition;

/**
* initialiseThumbs function
*
* handles the thumbnails including setting links and changing styles
*/
function initialiseThumbs()
{
	//Check the browser has enough DOM support
	if (!document.getElementById || !document.getElementsByTagName) return false;
	
	//Get all links
	var thumbs = document.getElementById('thumbs');
	var thumbLinks = thumbs.getElementsByTagName('a');
	
	//Change event for each one
	for (var i = 0; i < thumbLinks.length; i++)
	{
		thumbLinks[i].onclick = function()
		{
			changeImage(this);
			return false;
		}
	}
	
	//Add stylesheet and left / right scroll images
	var scrollStylesheet = document.createElement('link');
	scrollStylesheet.setAttribute('rel', 'stylesheet');
	scrollStylesheet.setAttribute('href', '../gallery/css/scroll.css');
	scrollStylesheet.setAttribute('type', 'text/css');
	document.getElementsByTagName('head')[0].appendChild(scrollStylesheet);
	
	var left = document.createElement('img');
	left.id = 'left';
	left.src = '../gallery/images/leftDisabled.gif';
	left.alt = '&laquo;';
	
	var right = document.createElement('img');
	right.id = 'right';
	right.src = '../gallery/images/rightDisabled.gif';
	right.alt = '&raquo;';
	
	thumbs.appendChild(left);
	thumbs.appendChild(right);
	
	//Set up image event handlers
	var innerThumbs = document.getElementById('innerThumbs');
	innerThumbs.style.width = (thumbLinks.length * 71) + 'px';
	innerThumbs.style.left = '15px';
	thumbPosition = 15;
	
	left.onmouseover = function()
	{
		this.src = '../gallery/images/leftActive.gif';
		moveInterval = window.setInterval('scrollThumbsLeft()', 10);
	}
	
	left.onmouseout = function()
	{
		this.src = '../gallery/images/leftDisabled.gif';
		window.clearInterval(moveInterval);
	}
	
	right.onmouseover = function()
	{
		this.src = '../gallery/images/rightActive.gif';
		moveInterval = window.setInterval('scrollThumbsRight()', 10);
	}
	
	right.onmouseout = function()
	{
		this.src = '../gallery/images/rightDisabled.gif';
		window.clearInterval(moveInterval);
	}
}

function scrollThumbsLeft()
{
	var innerThumbs = document.getElementById('innerThumbs');
	
	//Scroll left
	if (thumbPosition < 15)
	{
		thumbPosition += 4;
	}
	else
	{
		thumbPosition = 15;
		window.clearInterval(moveInterval);
	}
	innerThumbs.style.left = thumbPosition + 'px';
}

function scrollThumbsRight()
{
	var innerThumbs = document.getElementById('innerThumbs');
	
	//Scroll right
	var width = innerThumbs.offsetWidth;
	
	if (width < 420) return false;
	
	if (thumbPosition <= (420 - width))
	{
		thumbPosition = 420 - width;
		window.clearInterval(moveInterval);
	}
	else
	{
		thumbPosition -= 4;
	}
	innerThumbs.style.left = thumbPosition + 'px';
}

/**
* changeImage function
*
* changes the currently displayed image
*/
function changeImage(link)
{
	if (!document.getElementById) return false;
	
	window.clearTimeout(fadeTimer);
	
	//Set the active thumbnail
	var thumbs = document.getElementById('thumbs');
	var thumbLinks = thumbs.getElementsByTagName('a');
	
	for (var i = 0; i < thumbLinks.length; i++)
	{
		if (thumbLinks[i] == link)
		{
			thumbLinks[i].getElementsByTagName('img')[0].className = 'active';
		}
		else
		{
			thumbLinks[i].getElementsByTagName('img')[0].className = '';
		}
	}
	
	//Set the src and alt attributes
	var imageContainer = document.getElementById('imageContainer');
	var galleryImage = document.getElementById('galleryImage');
	
	setOpacity(galleryImage, 0);
	imageContainer.className = 'loading';
	
	var href = link.getAttribute('href');
	var image = href.substring(href.indexOf('?img=') + 5);
	
	//When loading is complete hide the loading icon and fade the image in
	galleryImage.onload = function()
	{
		imageContainer.className = '';
		fadeUp('galleryImage', 0);
	}
	
	//Fix Safari's annoying image swap resize bug
	if (navigator.userAgent.indexOf('Safari') != -1)
	{
		galleryImage.setAttribute('src', '../gallery/images/blank.gif');
	}
	
	galleryImage.setAttribute('src', '../gallery/images/gallery/' + image);
}

/**
* setOpacity function
*
* function to overcome the fact that browsers use different ways of setting opacity
*/
function setOpacity(element, opacity)
{
	//Fixes FF flicker
	opacity = (opacity == 100) ? 99.999 : opacity;
	
	//CSS3 (Implemented in newer version of Mozilla, FF and Safari)
	element.style.opacity = opacity / 100;
	//Old Firefox & Mozilla
	element.style.MozOpacity = opacity / 100;
	//IE
	element.style.filter = 'alpha(opacity:' + opacity + ')';
}

/**
* fadeUp function
*
* fades an element up from starting opacity to 100%
*/
function fadeUp(elementId, opacity)
{
	setOpacity(document.getElementById(elementId), opacity);
	
	if (opacity < 100)
	{
		opacity += 10;
		fadeTimer = window.setTimeout("fadeUp('" + elementId +"'," + opacity + ")", 100);
	}
}

//Add load events
addLoadEvent(initialiseThumbs);