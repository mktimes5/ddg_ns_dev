/// this library is loaded via the view template //

'use strict';
// NodeList.forEach Polyfill
if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        thisArg = thisArg || window;
        for (var i = 0; i < this.length; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}

window.onload = teamBioXfer;


function teamBioXfer() {
    // using simple state manager to toggle desktop and mobile functions
    ssm.addState({
        id: 'desk',
        query: '(min-width: 40em)',
        onEnter: function () {
            teamEffect.deskEffect();
            //console.log('desk effect called');
        },
    });

    ssm.addState({
        id: 'mobile',
        query: '(max-width: 40em)',
        onEnter: function() {
            teamEffect.mobileEffect();
        }
    });
}

let teamEffect = {

        teamTriggers: document.querySelectorAll('.team-trigger'),

        deskBio: function() {
            //this.clearActiveClass;
            //this would be the el passed in deskListen for each
            //console.log(this);

            let findBios = document.querySelectorAll('.modal-team-bio');

            findBios.forEach(yy => {
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

            let elBio = this.previousElementSibling.innerHTML;
            let bioRow = this.parentNode.parentElement.parentElement;
            let bioRowNext = bioRow.nextElementSibling;
            bioRowNext.innerHTML = elBio;
            bioRowNext.classList.toggle("active");

            //highlight name and role
            let teamName = this.parentElement.nextElementSibling;
            teamName.classList.toggle("active");

            let teamRole = teamName.nextElementSibling;
            teamRole.classList.toggle("active");
        },


        mobBio: function() {
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

            let findMobActive = document.querySelectorAll('.team-bio-mobile');
            findMobActive.forEach(yy =>{
                if ( yy.classList.contains("active") ) {
                    yy.classList.remove("active");
                }
            })

            let elBio = this.previousElementSibling.innerHTML;
            let mobBio = this.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;
            mobBio.innerHTML = elBio;
            mobBio.classList.toggle("active");

            //highlight name and role
            let teamName = this.parentElement.nextElementSibling;

            teamName.classList.toggle("active");

            let teamRole = teamName.nextElementSibling;

            teamRole.classList.toggle("active");




        },

        deskListen: function() {
            this.teamTriggers.forEach(el => {
                el.addEventListener('click', this.deskBio);
            })
        },

        deskSilence: function() {
            this.teamTriggers.forEach(el => {
                el.removeEventListener('click', this.deskBio);
            })
        },

        mobileListen: function() {
          this.teamTriggers.forEach(el => {
              el.addEventListener('click', this.mobBio);
          })
        },

        mobileSilence: function() {
          this.teamTriggers.forEach(el => {
              el.removeEventListener('click', this.mobBio);
          })
        },

        clearActiveClass: function() {
            let findBios = document.querySelectorAll('.modal-team-bio');

            findBios.forEach(yy => {
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

            let findMobActive = document.querySelectorAll('.team-bio-mobile');
            findMobActive.forEach(yy =>{
                yy.innerHTML = " ";
                if ( yy.classList.contains("active") ) {
                yy.classList.remove("active");
                }
            })
        },

        // Desktop Function - - - - - - - - - - //

        deskEffect: function() {
            this.mobileSilence();
            this.clearActiveClass();
            this.deskListen();
        }, // end function deskEffect --- /

        // Mobile Function - - - - - - - - - - //

        mobileEffect: function() {
            this.deskSilence();
            this.clearActiveClass();
            this.mobileListen();
        } // end function mobileEffect --- /

} // team effect
