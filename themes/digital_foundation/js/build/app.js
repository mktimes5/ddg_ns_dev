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

// </ /// header effect //// 

//  Team toggle

function teamBioXfer() {


            let toggleEle = document.querySelectorAll('.team-trigger');

            toggleEle.forEach(el => {
                el.addEventListener('click', bioXfer);

            function bioXfer() {
                // get the team members bio //

                ssm.addState({
                    id: 'mobile',
                    query: '(min-width: 40em)',
                    onEnter: function () {
                        deskEffects();
                    },
                    onLeave: function () {
                        mobileRemoval();
                    }
                });
                function mobTog() {
                    alert('mobTog');
                }

            function deskEffects() {
                console.log(el);
                el.removeEventListener('click', mobTog)
                let findActive = document.querySelectorAll('.modal-team-bio');

                findActive.forEach(yy => {
                        if (yy.classList.contains("active") ) {
                            yy.classList.remove("active");
                        }

                })

                let findTeam = document.querySelectorAll('.team-name');

                findTeam.forEach(xx => {
                    if ( xx.classList.contains("active") ) {
                    xx.classList.remove("active");
                    }
                })

                let findRole = document.querySelectorAll('.team-role');
                findRole.forEach(zz => {
                    if ( zz.classList.contains("active") ) {
                        zz.classList.remove("active");
                    }

                })

                let elBio = el.previousElementSibling.textContent;
                // get the next row element //
                //console.log(elBio);
                let bioRow = el.parentNode.parentElement.parentElement;
                ///console.log(bioRow);
                let bioRowNext = bioRow.nextElementSibling;
                bioRowNext.textContent = elBio;
                bioRowNext.classList.toggle("active");

                //highlight name and role
                let teamName = el.parentElement.nextElementSibling;
                teamName.classList.toggle("active");

                let teamRole = teamName.nextElementSibling;
                teamRole.classList.toggle("active");

            } //deskeffects

            function mobileRemoval() {
                let findActive = document.querySelectorAll('.modal-team-bio');

                findActive.forEach(yy => {
                        if (yy.classList.contains("active") ) {
                            yy.classList.remove("active");
                        }

                })

                let findTeam = document.querySelectorAll('.team-name');

                findTeam.forEach(xx => {
                    if ( xx.classList.contains("active") ) {
                    xx.classList.remove("active");
                    }
                })

                let findRole = document.querySelectorAll('.team-role');
                findRole.forEach(zz => {
                    if ( zz.classList.contains("active") ) {
                        zz.classList.remove("active");
                    }

                })

                let untoggleEle = document.querySelectorAll('.team-trigger');

                untoggleEle.forEach(tt => {
                    tt.removeEventListener('click', bioXfer);

                 })

                let mobileToggleEle = document.querySelectorAll('.team-trigger');
                mobileToggleEle.forEach(uu => {
                    uu.addEventListener('click', mobTog);

                })

            
            } //mobileRemoval
        } //bioXfer         
                
        })

        
      


    
	
}

window.onload = teamBioXfer;

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



