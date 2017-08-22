//$(document).foundation();
/// header effect ////
"use strict";var last_scroll_pos=0;var scrolling=false;// ie for-each polyfill
(function(){if(typeof NodeList.prototype.forEach==="function")return false;NodeList.prototype.forEach=Array.prototype.forEach;})();function headerToggle(sPosition){var headerEle=document.querySelector('.region-header');var contentEle=document.getElementById('content');if(sPosition>500){if(!headerEle.classList.contains('header-scroll')){headerEle.classList.add('header-scroll');contentEle.classList.add('content-scroll');}}else if(sPosition<500){if(headerEle.classList.contains('header-scroll')){headerEle.classList.remove('header-scroll');contentEle.classList.remove('content-scroll');}}}function logoToggle(sPosition){var logoEle=document.querySelector('.site-logo');if(sPosition>500){if(!logoEle.classList.contains('logo-scroll')){logoEle.classList.add('logo-scroll');}}else if(sPosition<500){if(logoEle.classList.contains('logo-scroll')){logoEle.classList.remove('logo-scroll');}}}var footerMenu=document.getElementById("mobile-footer");footerMenu.addEventListener("load",mobileMenu());function mobileMenu(){var mobileLinks=document.querySelectorAll('.linkicon__item');var currentPage=window.location.href;mobileLinks.forEach(function(el){if(currentPage==el.href){el.classList.toggle("active");}});}// </ /// header effect //// 
//  Team toggle
window.onscroll=function(){last_scroll_pos=window.pageYOffset;if(!scrolling){window.requestAnimationFrame(function(){headerToggle(last_scroll_pos);logoToggle(last_scroll_pos);scrolling=false;});}scrolling=true;};//let rellax = new Rellax('.rellax');
//scroll magic
var controller=new ScrollMagic.Controller();// create a scene
new ScrollMagic.Scene({duration:669,// the scene should last for a scroll distance of
offset:10// start this scene after scrolling for
}).setPin("#blog-title")// pins the element for the the scene's duration
.addTo(controller);// assign the scene to the controller
new ScrollMagic.Scene({duration:669,// the scene should last for a scroll distance of
offset:10// start this scene after scrolling for
}).setPin("#work-title")// pins the element for the the scene's duration
.addTo(controller);// assign the scene to the controller