/**
=========================================================================
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Adaptado para Vue + Inertia + Laravel (por Kelvin)
File: script.js
=========================================================================
=========================================================================
*/

'use strict';
var flg = '0';

function menu_click() {
  var elem = document.querySelectorAll('.pc-navbar li');
  for (var j = 0; j < elem.length; j++) {
    elem[j].removeEventListener('click', function () {});
  }

  var elem = document.querySelectorAll('.pc-navbar li:not(.pc-trigger) .pc-submenu');
  for (var j = 0; j < elem.length; j++) {
    elem[j].style.display = 'none';
  }

  var pc_link_click = document.querySelectorAll('.pc-navbar > li:not(.pc-caption).pc-hasmenu');
  for (var i = 0; i < pc_link_click.length; i++) {
    pc_link_click[i].addEventListener('click', function (event) {
      event.stopPropagation();
      var targetElement = event.target;
      if (targetElement.tagName == 'SPAN') targetElement = targetElement.parentNode;

      if (targetElement.parentNode.classList.contains('pc-trigger')) {
        targetElement.parentNode.classList.remove('pc-trigger');
        slideUp(targetElement.parentNode.children[1], 200);
        window.setTimeout(() => {
          targetElement.parentNode.children[1].removeAttribute('style');
          targetElement.parentNode.children[1].style.display = 'none';
        }, 200);
      } else {
        var tc = document.querySelectorAll('li.pc-trigger');
        for (var t = 0; t < tc.length; t++) {
          var c = tc[t];
          c.classList.remove('pc-trigger');
          slideUp(c.children[1], 200);
          window.setTimeout(() => {
            c.children[1].removeAttribute('style');
            c.children[1].style.display = 'none';
          }, 200);
        }
        targetElement.parentNode.classList.add('pc-trigger');
        var submenu_list = targetElement.children[1];
        if (submenu_list) slideDown(targetElement.parentNode.children[1], 200);
      }
    });
  }

  if (document.querySelector('.navbar-content')) {
    new SimpleBar(document.querySelector('.navbar-content'));
  }

  var pc_sub_link_click = document.querySelectorAll('.pc-navbar > li:not(.pc-caption) li.pc-hasmenu');
  for (var i = 0; i < pc_sub_link_click.length; i++) {
    pc_sub_link_click[i].addEventListener('click', function (event) {
      var targetElement = event.target;
      if (targetElement.tagName == 'SPAN') targetElement = targetElement.parentNode;
      event.stopPropagation();
      if (targetElement.parentNode.classList.contains('pc-trigger')) {
        targetElement.parentNode.classList.remove('pc-trigger');
        slideUp(targetElement.parentNode.children[1], 200);
      } else {
        var tc = targetElement.parentNode.parentNode.children;
        for (var t = 0; t < tc.length; t++) {
          var c = tc[t];
          c.classList.remove('pc-trigger');
          if (c.tagName == 'LI') c = c.children[0];
          if (c.parentNode.classList.contains('pc-hasmenu')) {
            slideUp(c.parentNode.children[1], 200);
          }
        }
        targetElement.parentNode.classList.add('pc-trigger');
        var submenu_list = targetElement.parentNode.children[1];
        if (submenu_list) {
          submenu_list.removeAttribute('style');
          slideDown(submenu_list, 200);
        }
      }
    });
  }
}

document.addEventListener('DOMContentLoaded', menu_click);

document.addEventListener('DOMContentLoaded', function () {
  feather.replace();

  if (document.querySelector('html').hasAttribute('data-pc-layout')) {
    if (document.querySelector('html').getAttribute('data-pc-layout') == 'horizontal') {
      var docW = window.innerWidth;
      if (docW <= 1024) add_scroller();
    }
  } else add_scroller();

  var mobile_collapse_over = document.querySelector('#mobile-collapse');
  if (mobile_collapse_over) {
    mobile_collapse_over.addEventListener('click', function () {
      var mobile_sidebar = document.querySelector('.pc-sidebar');
      if (mobile_sidebar) {
        if (document.querySelector('.pc-sidebar').classList.contains('mob-sidebar-active')) {
          rm_menu();
        } else {
          document.querySelector('.pc-sidebar').classList.add('mob-sidebar-active');
          document.querySelector('.pc-sidebar').insertAdjacentHTML('beforeend', '<div class="pc-menu-overlay"></div>');
          document.querySelector('.pc-menu-overlay').addEventListener('click', function () {
            rm_menu();
          });
        }
      }
    });
  }

  if (document.querySelector('.header-notification-scroll')) new SimpleBar(document.querySelector('.header-notification-scroll'));
  if (document.querySelector('.profile-notification-scroll')) new SimpleBar(document.querySelector('.profile-notification-scroll'));
  if (document.querySelector('.component-list-card .scroll-div')) new SimpleBar(document.querySelector('.component-list-card .scroll-div'));

  var sidebar_hide = document.querySelector('#sidebar-hide');
  if (sidebar_hide) {
    sidebar_hide.addEventListener('click', function () {
      document.querySelector('.pc-sidebar').classList.toggle('pc-sidebar-hide');
    });
  }

  if (document.querySelector('.trig-drp-search')) {
    const search_drp = document.querySelector('.trig-drp-search');
    search_drp.addEventListener('shown.bs.dropdown', (event) => {
      document.querySelector('.drp-search input').focus();
    });
  }

  setLayout();
  var if_layout = document.querySelectorAll('.theme-main-layout');
  var layoutValue = 'vertical';
  if (if_layout) {
    var preset_layout = document.querySelectorAll('.theme-main-layout > a');
    preset_layout.forEach(function (element) {
      element.addEventListener('click', function () {
        location.reload();
        document.querySelectorAll('.theme-main-layout > a').forEach(function (el) {
          el.classList.remove('active');
        });
        this.classList.add('active');
        layoutValue = this.getAttribute('data-value') || 'vertical';
        localStorage.setItem('layout', layoutValue);
        setLayout();
      });
    });
  }
});

function setLayout() {
  var layout = localStorage.getItem('layout');
  main_layout_change(layout);

  if (layout !== null && layout !== '') {
    var script = document.createElement('script');
    if (layout === 'horizontal') {
      document.querySelector('.pc-sidebar').classList.add('d-none');
      script.src = '/assets/js/layout-horizontal.js'; // ✅ corrigido
      document.body.appendChild(script);
    } else if (layout === 'color-header') {
      const logo = document.querySelector('.pc-sidebar .m-header .logo-lg');
      if (logo) logo.setAttribute('src', '/assets/images/logo-white.svg'); // ✅ corrigido
    } else if (layout === 'compact') {
      script.src = '/assets/js/layout-compact.js'; // ✅ corrigido
      document.body.appendChild(script);
    } else if (layout === 'tab') {
      script.src = '/assets/js/layout-tab.js'; // ✅ corrigido
      document.body.appendChild(script);
    }
  }

  if (layout === null) {
    main_layout_change('vertical');
    localStorage.setItem('layout', 'vertical');
  }
}

function add_scroller() {
  if (document.querySelector('.navbar-content')) {
    new SimpleBar(document.querySelector('.navbar-content'));
  }
}

function rm_menu() {
  var sidebar = document.querySelector('.pc-sidebar');
  var topbar = document.querySelector('.topbar');
  if (sidebar) sidebar.classList.remove('mob-sidebar-active');
  if (topbar) topbar.classList.remove('mob-sidebar-active');
  var sidebarOverlay = document.querySelector('.pc-sidebar .pc-menu-overlay');
  var topbarOverlay = document.querySelector('.topbar .pc-menu-overlay');
  if (sidebarOverlay) sidebarOverlay.remove();
  if (topbarOverlay) topbarOverlay.remove();
}

window.addEventListener('load', function () {
  var loader = document.querySelector('.loader-bg');
  if (loader) {
    loader.style.transition = 'opacity 0.5s ease';
    loader.style.opacity = '0';
    setTimeout(function () {
      loader.remove();
    }, 500);
  }
});

document.querySelectorAll('.auth-main.v2 .img-brand').forEach((img) => {
  img.setAttribute('src', '/assets/images/logo-white.svg'); // ✅ corrigido
});

function removeClassByPrefix(node, prefix) {
  node.classList.forEach((value) => {
    if (value.startsWith(prefix)) node.classList.remove(value);
  });
}

let slideUp = (target, duration = 0) => {
  target.style.transitionProperty = 'height, margin, padding';
  target.style.transitionDuration = duration + 'ms';
  target.style.boxSizing = 'border-box';
  target.style.height = target.offsetHeight + 'px';
  target.offsetHeight;
  target.style.overflow = 'hidden';
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
};

let slideDown = (target, duration = 0) => {
  target.style.removeProperty('display');
  let display = window.getComputedStyle(target).display;
  if (display === 'none') display = 'block';
  target.style.display = display;
  let height = target.offsetHeight;
  target.style.overflow = 'hidden';
  target.style.height = 0;
  target.offsetHeight;
  target.style.transitionProperty = 'height, margin, padding';
  target.style.transitionDuration = duration + 'ms';
  target.style.height = height + 'px';
  window.setTimeout(() => {
    target.style.removeProperty('height');
    target.style.removeProperty('overflow');
    target.style.removeProperty('transition-duration');
    target.style.removeProperty('transition-property');
  }, duration);
};

var slideToggle = (target, duration = 0) => {
  if (window.getComputedStyle(target).height === '0px') return slideDown(target, duration);
  else return slideUp(target, duration);
};
