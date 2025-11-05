/**
=========================================================================
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Adaptado para Vue + Inertia + Laravel (por Kelvin)
File: layout-tab.js
=========================================================================
=========================================================================
*/

'use strict';

(function () {
  // Define o layout atual
  document.documentElement.setAttribute('data-pc-layout', 'tab');

  // 🔹 Obtém a estrutura principal da sidebar
  const sidebar = document.querySelector('.navbar-wrapper');
  const navContent = document.querySelector('.pc-sidebar > .navbar-wrapper > .navbar-content');

  if (!sidebar) return;

  // 🔹 Esconde o conteúdo existente
  if (navContent) {
    navContent.style.display = 'none';
  }

  // 🔹 Cria nova estrutura base
  const tabContainer = document.createElement('div');
  tabContainer.className = 'tab-container';

  const tabSidemenu = document.createElement('div');
  tabSidemenu.className = 'tab-sidemenu';

  const tabLinkUl = document.createElement('ul');
  tabLinkUl.className = 'pc-tab-link nav flex-column';
  tabLinkUl.setAttribute('role', 'tablist');
  tabLinkUl.id = 'pc-layout-submenus';
  tabSidemenu.appendChild(tabLinkUl);

  const tabLinkDiv = document.createElement('div');
  tabLinkDiv.className = 'tab-link';

  const navbarContentDiv = document.createElement('div');
  navbarContentDiv.className = 'navbar-content';

  const tabContentDiv = document.createElement('div');
  tabContentDiv.className = 'tab-content';
  tabContentDiv.id = 'pc-layout-tab';

  const pcNavbarUl = document.createElement('ul');
  pcNavbarUl.className = 'pc-navbar';

  // 🔹 Copia menu existente, se houver
  const existingMenuList = document.querySelector('.pc-navbar > .menu-list');
  if (existingMenuList) {
    pcNavbarUl.appendChild(existingMenuList.cloneNode(true));
    existingMenuList.remove();
  }

  // Monta estrutura
  navbarContentDiv.appendChild(tabContentDiv);
  navbarContentDiv.appendChild(pcNavbarUl);
  tabLinkDiv.appendChild(navbarContentDiv);
  tabContainer.appendChild(tabSidemenu);
  tabContainer.appendChild(tabLinkDiv);
  sidebar.appendChild(tabContainer);

  // 🔹 Inicializa barras de rolagem (SimpleBar)
  if (window.SimpleBar) {
    const sideScroll = document.querySelector('.tab-container > .tab-sidemenu');
    const mainScroll = document.querySelector('.tab-container > .tab-link .navbar-content');
    if (sideScroll) new SimpleBar(sideScroll);
    if (mainScroll) new SimpleBar(mainScroll);
  }

  // 🔹 Oculta todos os submenus inicialmente
  document.querySelectorAll('.pc-navbar li .pc-submenu').forEach(el => {
    el.style.display = 'none';
  });

  // 🔹 Monta as abas
  setTabMenu();

  function setTabMenu() {
    const pcMenuList = document.querySelectorAll('.pc-navbar > li.pc-item');
    const pcTabMenuList = document.querySelector('.tab-container > .tab-sidemenu > .pc-tab-link');
    const pcTabLinkList = document.querySelector('.tab-container > .tab-link > .navbar-content > .tab-content');

    if (!pcMenuList.length || !pcTabMenuList || !pcTabLinkList) return;

    let pcNewList = '';
    let flagCount = 0;
    let flagHit = false;
    let tabBlankList = '';

    pcMenuList.forEach((item, index) => {
      if (item.classList.contains('pc-caption')) {
        flagCount++;

        // Adiciona aba lateral
        let menuIcon = '';
        try {
          menuIcon = item.children[1]?.outerHTML || item.children[0]?.innerHTML?.charAt(0) || '';
        } catch {
          menuIcon = '';
        }

        pcTabMenuList.insertAdjacentHTML(
          'beforeend',
          `<li class="nav-item">
            <a class="nav-link" data-pc-toggle="tab" data-pc-target="#pc-tab-${flagCount}" role="tab">
              ${menuIcon}
            </a>
          </li>`
        );

        // Adiciona conteúdo da aba anterior
        if (flagHit) {
          const tmpFlag = flagCount - 1;
          pcTabLinkList.insertAdjacentHTML(
            'beforeend',
            `<div class="tab-pane" id="pc-tab-${tmpFlag}" role="tabpanel">
              <ul class="pc-navbar">${pcNewList}</ul>
            </div>`
          );
          pcNewList = '';
        }

        item.remove();
        flagHit = true;
      } else {
        pcNewList += item.outerHTML;
        item.remove();

        // Último item
        if (index + 1 === pcMenuList.length) {
          pcTabLinkList.insertAdjacentHTML(
            'beforeend',
            `<div class="tab-pane" id="pc-tab-${flagCount}" role="tabpanel">
              <ul class="pc-navbar">${pcNewList}</ul>
            </div>`
          );
          pcNewList = '';
        }
      }
    });

    activateMenu();
    if (typeof menu_click === 'function') menu_click();
  }

  // 🔹 Marca o item ativo conforme URL
  function activateMenu() {
    const links = document.querySelectorAll('.pc-sidebar .pc-navbar a');
    const currentUrl = window.location.href.split(/[?#]/)[0];

    links.forEach(link => {
      if (link.href === currentUrl && link.getAttribute('href')) {
        link.classList.add('active');
        const tabPane = link.closest('.tab-pane');
        if (tabPane) changeTab(`#${tabPane.id}`);
      }
    });
  }

  // 🔹 Controle de clique nas abas
  document.querySelectorAll('.pc-tab-link .nav-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const target = e.currentTarget.getAttribute('data-pc-target');
      changeTab(target);
    });
  });

  // 🔹 Troca de aba (mostra e esconde)
  function changeTab(tabSelector) {
    const targetTab = document.querySelector(tabSelector);
    if (!targetTab) return;

    const allTabs = targetTab.parentElement.querySelectorAll('.tab-pane');
    const allLinks = document.querySelectorAll('.pc-tab-link .nav-link');

    allTabs.forEach(tab => {
      tab.classList.add('hidden');
      tab.classList.remove('block');
    });

    allLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('data-pc-target') === tabSelector) {
        link.classList.add('active');
      }
    });

    targetTab.classList.remove('hidden');
    targetTab.classList.add('block');
  }
})();
