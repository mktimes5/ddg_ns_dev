//$(document).foundation();

/// header effect ////
"use strict";

let last_scroll_pos = 0;
let scrolling = false;

// ie for-each polyfill
(function () {
    if ( typeof NodeList.prototype.forEach === "function" ) return false;
    NodeList.prototype.forEach = Array.prototype.forEach;
})();

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

let footerMenu = document.getElementById("mobile-footer");
footerMenu.addEventListener("load", mobileMenu());

function mobileMenu() {
	let mobileLinks = document.querySelectorAll('.linkicon__item');
    var currentPage = window.location.href;
	mobileLinks.forEach(el => {
		if (currentPage == el.href) {
			el.classList.toggle("active");
		}
	})
}

// </ /// header effect //// 

//  Team toggle

window.onscroll = function (){
	last_scroll_pos = window.pageYOffset;
	if ( !scrolling ) {
		
		window.requestAnimationFrame(function() {
      	headerToggle(last_scroll_pos);
      	logoToggle(last_scroll_pos);
      	scrolling = false;
    	});
		
    }
	scrolling = true;
}


let rellax = new Rellax('.rellax');
