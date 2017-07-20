/// this library is loaded via the view template //

'use strict';

window.onload = teamBioXfer;


(function () {
    if ( typeof NodeList.prototype.forEach === "function" ) return false;
    NodeList.prototype.forEach = Array.prototype.forEach;
})();

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

            let elBio = this.previousElementSibling.textContent;
            // get the next row element //
            //console.log(elBio);
            let bioRow = this.parentNode.parentElement.parentElement;
            ///console.log(bioRow);
            let bioRowNext = bioRow.nextElementSibling;
            bioRowNext.textContent = elBio;
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

            let elBio = this.previousElementSibling.textContent;
            let mobBio = this.parentNode.nextElementSibling.nextElementSibling.nextElementSibling;
            mobBio.textContent = elBio;
            mobBio.classList.toggle("active");

            //highlight name and role
            let teamName = this.parentElement.nextElementSibling;
            console.log(teamName);
            teamName.classList.toggle("active");

            let teamRole = teamName.nextElementSibling;
            console.log(teamRole);
            teamRole.classList.toggle("active");




        },

        deskListen: function() {
            console.log('deskListen called');
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
            console.log('mob listen called');
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
                yy.innerHTML = "";
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
