//$(document).foundation();

/// header effect ////
"use strict";

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

function mobileMenu() {
	let mobileLinks = document.querySelectorAll('.linkicon__item');
    var currentPage = window.location.href;
    console.log(currentPage);
	mobileLinks.forEach(el => {
        console.log(el.href);
		if (currentPage == el.href) {
			el.classList.toggle("active");

		}
	})
}

// </ /// header effect //// 

//  Team toggle

window.onload = mobileMenu;

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



