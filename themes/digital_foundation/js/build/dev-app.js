//$(document).foundation();




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

function teamBioReveal() {
	console.log('team reveal loaded');
	let toggleEle = document.querySelector('.team-Reveal');
	let revealEle = document.querySelector('.team-model');

	toggleEle.addEventListener("click", teamToggle);

	function teamToggle() {
		alert('Team Toggle');
	}
}

function helloFoo(){
	console.log('hello');
}

window.onload = helloFoo;

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





















