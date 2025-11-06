/**
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Support: https://codedthemes.support-hub.io/
File: themes.js (corrigido por ChatGPT)
=========================================================================
*/

'use strict';

let rtl_flag = false;
let dark_flag = false;

/* ============================================================
   ✅ APLICA O TEMA SALVO IMEDIATAMENTE (ANTES DE RENDERIZAR)
   ============================================================ */
(function () {
  try {
    const savedTheme = localStorage.getItem('theme');
    const preferred = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    const currentTheme = savedTheme || preferred;

    document.documentElement.setAttribute('data-pc-theme', currentTheme);
    dark_flag = currentTheme === 'dark';
  } catch (e) {
    console.warn('LocalStorage não disponível:', e);
  }
})();

/* ============================================================
   ✅ INICIALIZAÇÃO APÓS O DOM ESTAR PRONTO
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
  const currentTheme = document.documentElement.getAttribute('data-pc-theme') || 'light';
  layout_change(currentTheme);

  // Botões de troca de tema
  const layoutButtons = document.querySelectorAll('.theme-layout .btn');
  layoutButtons.forEach(btn => {
    btn.addEventListener('click', event => {
      event.stopPropagation();
      const value = event.currentTarget.getAttribute('data-value');
      const theme = value === 'true' ? 'light' : 'dark';

      document.documentElement.setAttribute('data-pc-theme', theme);
      localStorage.setItem('theme', theme);
      layout_change(theme);
    });
  });

  // Função de reset total
  const layout_reset = document.querySelector('#layoutreset');
  if (layout_reset) {
    layout_reset.addEventListener('click', () => {
      localStorage.clear();
      location.reload();
      localStorage.setItem('layout', 'vertical');
    });
  }

  // Mantém demais listeners originais (presets, cores, etc.)
  initColorPickers();
});

/* ============================================================
   ✅ FUNÇÃO CENTRAL DE MUDANÇA DE TEMA
   ============================================================ */
function layout_change(layout) {
  document.documentElement.setAttribute('data-pc-theme', layout);
  localStorage.setItem('theme', layout);

  const isDark = layout === 'dark';
  dark_flag = isDark;

  const logoSrc = isDark ? '../assets/images/logo-white.svg' : '../assets/images/logo-dark.svg';
  updateLogo('.navbar-brand .logo-lg', logoSrc);
  updateLogo('.auth-main.v1 .auth-sidefooter img', logoSrc);
  updateLogo('.auth-logo', logoSrc);
  updateLogo('.footer-top .footer-logo', logoSrc);

  const activeControl = document.querySelector('.theme-layout .btn.active');
  if (activeControl) activeControl.classList.remove('active');

  const newActive = document.querySelector(`.theme-layout .btn[data-value='${!isDark}']`);
  if (newActive) newActive.classList.add('active');
}

function updateLogo(selector, src) {
  const el = document.querySelector(selector);
  if (el) el.setAttribute('src', src);
}

/* ============================================================
   ✅ RESTANTE DAS FUNÇÕES ORIGINAIS
   ============================================================ */

function layout_caption_change(value) {
  document.documentElement.setAttribute('data-pc-sidebar-caption', value === 'true' ? 'true' : 'false');
}

function preset_change(value) {
  document.documentElement.className = value;
}

function main_layout_change(value) {
  document.documentElement.setAttribute('data-pc-layout', value);
}

function layout_rtl_change(value) {
  const html = document.documentElement;
  if (value === 'true') {
    rtl_flag = true;
    html.setAttribute('data-pc-direction', 'rtl');
    html.setAttribute('dir', 'rtl');
    html.setAttribute('lang', 'ar');
  } else {
    rtl_flag = false;
    html.setAttribute('data-pc-direction', 'ltr');
    html.setAttribute('dir', 'ltr');
    html.removeAttribute('lang');
  }
}

function change_box_container(value) {
  const content = document.querySelector('.pc-content');
  const footer = document.querySelector('.footer-wrapper');
  if (!content || !footer) return;

  if (value === 'true') {
    content.classList.add('container');
    footer.classList.add('container');
    footer.classList.remove('container-fluid');
  } else {
    content.classList.remove('container');
    footer.classList.remove('container');
    footer.classList.add('container-fluid');
  }
}

function layout_theme_sidebar_change(value) {
  document.documentElement.setAttribute('data-pc-sidebar_theme', value);
}

function header_change(value) {
  document.documentElement.setAttribute('data-pc-header', value);
}

function navbar_change(value) {
  document.documentElement.setAttribute('data-pc-navbar', value);
}

function logo_change(value) {
  document.documentElement.setAttribute('data-pc-logo', value);
}

function caption_change(value) {
  document.documentElement.setAttribute('data-pc-caption', value);
}

function drp_menu_icon_change(value) {
  document.documentElement.setAttribute('data-pc-drp-menu-icon', value);
}

function drp_menu_link_icon_change(value) {
  document.documentElement.setAttribute('data-pc-drp-menu-link-icon', value);
}

function nav_image_change(value) {
  document.documentElement.setAttribute('data-pc-navimg', value);
}

/* ============================================================
   ✅ FUNÇÃO DE INICIALIZAÇÃO DAS CORES (mantém tuas configs)
   ============================================================ */
function initColorPickers() {
  const sections = [
    { selector: '.header-color', handler: header_change },
    { selector: '.navbar-color', handler: navbar_change },
    { selector: '.logo-color', handler: logo_change },
    { selector: '.caption-color', handler: caption_change },
    { selector: '.navbar-img', handler: nav_image_change },
    { selector: '.drp-menu-icon', handler: drp_menu_icon_change },
    { selector: '.drp-menu-link-icon', handler: drp_menu_link_icon_change },
  ];

  sections.forEach(({ selector, handler }) => {
    document.querySelectorAll(`${selector} > a`).forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        let target = e.target;
        if (['SPAN', 'I'].includes(target.tagName)) target = target.parentNode;
        const val = target.getAttribute('data-value');
        handler(val);
      });
    });
  });
}
