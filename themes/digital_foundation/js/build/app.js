//$(document).foundation();

/// header effect ////

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

// </ /// header effect //// 

//  Team toggle


function teamBioReveal() {
	console.log('team bio reveal function on');
	let toggleEle = document.querySelectorAll('.team-reveal');
	//let revealEle = document.querySelectorAll('.team-modal');
	//console.log(toggleEle);
	toggleEle.forEach(el => {
		el.addEventListener('click', teamToggle);

		function teamToggle() {
			let checkToggles = document.querySelectorAll('.bio-expanded');
			
			if (checkToggles.length < 1 ) {
				console.log('Team Toggle');
				//console.log(checkToggles.length);
				//console.log(  el.parentNode.parentNode );
				let elParent = el.parentNode.parentNode;
				let revealParentNodes = elParent.childNodes;
				//console.log(revealParentNodes);
				// <! this will need to change if you are displaying twig template suggestions in theme !>
				// <! show twig parent index = 8 | Production parent index = 2
				let revealParent = revealParentNodes[8]; 
				//console.log(revealParent);
				revealParent.classList.toggle('bio-expanded');
				//console.log( document.querySelectorAll('.bio-expanded'))
			} else if ( checkToggles.length >= 1 ) {
				
				var removeExp = document.querySelectorAll('.bio-expanded');
				//console.log( document.querySelectorAll('.bio-expanded') )
				removeExp.forEach(el => {
					el.classList.remove('bio-expanded');
				});
				//console.log('Team Toggle');
				//console.log(checkToggles.length);
				//console.log(  el.parentNode.parentNode );
				let elParent = el.parentNode.parentNode;
				let revealParentNodes = elParent.childNodes;
				//console.log(revealParentNodes);
				// <! this will need to change if you are displaying twig template suggestions in theme !>
				// <! show twig parent index = 8 | Production parent index = 2
				let revealParent = revealParentNodes[8]; 
				//console.log(revealParent);
				revealParent.classList.toggle('bio-expanded');
			}
		}
	})
	

}

window.onload = teamBioReveal;

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



