/**
* @name {Mobile Menu Script} MENU.JS
* @author Isaiah Robinson
* @organization CANSA Centre For Community and Cultural Development
* @date 05-28-2021
*
* Purpose:
* This script fixes the mobile menu functionality that has seemed to have
* stopped working, most likely due to a previous jQuery enqueue issue.
*
* Table of Contents.
* i. Element items
* i. i. Element items event listeners
* ii. Helper Functions
* ii. i. Main Menu Helper Function
* ii. ii. Top BarHelper Function
*/

// On page load
document.addEventListener('DOMContentLoaded', function () {
  const PHP_LOG = document.getElementsByClassName('php-log');
  for (var i = 0; i < PHP_LOG.length; i++) {
    console.log(PHP_LOG[i].innerHTML);
  }

    let toggle    = false; // menu is closed by default
    let topToggle = false; // menu is closed by default
    // Main Menu Nav
    let mobileMenuEL   = document.getElementById('primary-menu-toggle'), // menu button
        siteHeaderMenu = document.getElementById('site-header-menu'), // main menu group
        subMenus       = document.getElementsByClassName('menu-item-has-children'), // main sub menus
        subMenuUL      = document.getElementsByClassName('sub-menu'), // sub menu list items
        // Top Bar
        topMenuEL      = document.getElementById('header-top-toggle'), // top bar button
        topMenuCont    = document.getElementById('site-top-header-mobile-container'); // top bar button

    // Menu Click Events
    mobileMenuEL.addEventListener("click", mobileMenu); // main menu event listener
    topMenuEL.addEventListener("click", topMenu); // top menu event listener

    // H E L P E R  F U N C T I O N S
    // M A I N   M O B I L E   M E N U
    // Menu toggle Helper Function
    function mobileMenu() {
      toggle = !toggle // track if menu display is shown
      // conditionaly display or hide the mobile menu
      if (toggle) {
        siteHeaderMenu.style.display = "block"; // display menu
      } else {
        siteHeaderMenu.style.display = "none"; // hide menu
      }

      // add sub menu event listeners
      for (var i = 0; i < subMenus.length; i++) {
       subMenus[i].addEventListener("click", mobileSubMenu);
      }

      // S U B    M E N U    H E L P E R    F U N C T I O N
      function mobileSubMenu() {
        for (var i = 0; i < subMenuUL.length; i++) {
         subMenuUL[i].style.display = "none"; // hide previous submenus
        }
        this.lastElementChild.style.display = "block"; // display submenu
      }
    }

    // T O P   M O B I L E   M E N U
    function topMenu() {
      topToggle = !topToggle // track if top menu display is shown
      if (topToggle) {
        topMenuCont.style.display = "block"; // display top bar menu
      } else {
        topMenuCont.style.display = "none"; // hide top bar menu
      }
    }
});
