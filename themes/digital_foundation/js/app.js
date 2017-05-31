//$(document).foundation();

/// header effect ////
var babelTest = "this is a let variable";
console.log(babelTest);

let last_scroll_pos = 0;
let scrolling = false;

function headerToggle( sPosition ) {
	let headerEle = document.querySelector('.region-header');
	let contentEle = document.getElementById('content');
	if (sPosition > 500)  {
		if (!headerEle.classList.contains('header-scroll')) {
			headerEle.classList.add('header-scroll');
			contentEle.classList.add('content-scroll');
		}
	} else if (sPosition < 500) {
		if (headerEle.classList.contains('header-scroll')) {
			headerEle.classList.remove('header-scroll');
			contentEle.classList.remove('content-scroll');
		}
	}
	
}

function logoToggle( sPosition ) {
	let logoEle = document.querySelector('.site-logo');
	if (sPosition > 500)  {
		if (!logoEle.classList.contains('logo-scroll')) {
			logoEle.classList.add('logo-scroll');
		}
	} else if (sPosition < 500) {
		if (logoEle.classList.contains('logo-scroll')) {
			logoEle.classList.remove('logo-scroll');
		}
	}
}

window.onscroll = function (){
	last_scroll_pos = window.scrollY;
	if ( !scrolling ) {
		
		window.requestAnimationFrame(function() {
      	headerToggle(last_scroll_pos);
      	logoToggle(last_scroll_pos);
      	scrolling = false;
    	});
		
    }
	scrolling = true;
}

























































































































