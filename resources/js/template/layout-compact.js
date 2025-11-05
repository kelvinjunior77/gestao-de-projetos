/**
=========================================================================
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Adaptado para Vue + Inertia + Laravel (por Kelvin)
File: layout-compact.js
=========================================================================
=========================================================================
*/

'use strict';

(function () {
  // Define o layout como "compact"
  document.documentElement.setAttribute('data-pc-layout', 'compact');

  // 🔹 Alternar visibilidade da sidebar compacta
  const sidebarToggle = document.querySelector('#sidebar-hide');
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
      const body = document.body;
      body.classList.toggle('pc-sidebar-hide');
    });
  }

  // 🔹 Controla o clique nos itens do menu (abrir/fechar submenus)
  const menuItems = document.querySelectorAll('.pc-navbar > li:not(.pc-caption)');
  menuItems.forEach((menuItem) => {
    menuItem.addEventListener('click', (event) => {
      const sidebar = document.querySelector('.pc-sidebar');
      const body = document.body;
      if (!sidebar) return;

      sidebar.classList.add('pc-compact-submenu-active');
      body.classList.add('pc-compact-submenu-active');

      let targetElement = event.target;
      if (targetElement.tagName === 'SPAN') {
        targetElement = targetElement.parentNode;
      }

      // Se o item clicado não estiver ativo, remove classes globais
      const parentLi = targetElement.closest('li');
      if (!parentLi?.classList.contains('pc-trigger')) {
        sidebar.classList.remove('pc-compact-submenu-active');
        body.classList.remove('pc-compact-submenu-active');
      } else {
        sidebar.classList.add('pc-compact-submenu-active');
        body.classList.add('pc-compact-submenu-active');
      }
    });
  });

  // 🔹 Remove a classe "active" de itens com URLs correspondentes (melhor para modo compacto)
  const sidebarLinks = document.querySelectorAll('.pc-sidebar .pc-navbar a');
  const currentUrl = window.location.href.split(/[?#]/)[0];

  sidebarLinks.forEach((link) => {
    const href = link.getAttribute('href');
    if (href && link.href === currentUrl) {
      const parentLi = link.closest('li');
      const parentTrigger = link.closest('.pc-trigger');
      const parentActive = link.closest('.active');

      if (parentLi) parentLi.classList.remove('active');
      if (parentTrigger) parentTrigger.classList.remove('pc-trigger', 'active');
      if (parentActive) parentActive.classList.remove('active');
    }
  });
})();
