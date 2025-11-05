/**
=========================================================================
=========================================================================
Template Name: Datta Able - Tailwind Admin Template
Author: CodedThemes
Adaptado para Vue + Inertia + Laravel (por Kelvin)
File: layout-horizontal.js
=========================================================================
=========================================================================
*/

'use strict';

(function () {
  // Define layout horizontal
  document.documentElement.setAttribute('data-pc-layout', 'horizontal');

  const navContent = document.querySelector('.navbar-content');
  if (!navContent) return;
  const pc_nav_content = navContent.innerHTML;

  // ✅ Corrigido: caminho absoluto para o logo
  const logoSrc = '/assets/images/logo-dark.svg';
  const logoElement = document.querySelector('.b-brand .logo-lg');
  if (logoElement) {
    logoElement.setAttribute('src', logoSrc);
  }

  // Configuração inicial conforme largura da tela
  const docW = window.innerWidth;
  if (docW > 1024) {
    set_horizontal_menu();
    set_edge_menu();
  }

  // Redefine menu ao redimensionar janela
  window.addEventListener('resize', function () {
    const docW = window.innerWidth;
    const navbar = document.querySelector('.navbar-content');
    if (!navbar) return;

    navbar.innerHTML = pc_nav_content;

    if (docW >= 1024) {
      setTimeout(reinit_horizontal_menu, 500);
    } else {
      setTimeout(reinit_vertical_menu, 500);
    }
  });

  // 🔹 Muda para menu vertical (mobile)
  function reinit_vertical_menu() {
    feather.replace();
    if (typeof menu_click === 'function') menu_click();

    const navbar = document.querySelector('.navbar-content');
    if (navbar) new SimpleBar(navbar);
  }

  // 🔹 Reaplica o menu horizontal
  function reinit_horizontal_menu() {
    set_horizontal_menu();
    feather.replace();
    set_edge_menu();

    const overlay = document.querySelector('.pc-sidebar .pc-menu-overlay');
    if (overlay) overlay.remove();

    const submenus = document.querySelectorAll('.pc-navbar li:not(.pc-trigger) .pc-submenu');
    submenus.forEach((submenu) => submenu.removeAttribute('style'));
  }

  // 🔹 Define comportamento do menu horizontal
  function set_horizontal_menu() {
    const pc_menu_list = document.querySelectorAll('.pc-navbar > li.pc-item');
    let pc_new_list = '';
    let pc_sing_link = '';
    let flag_item = '';
    let flag_item_extra = '';
    let flag_w = 0;
    let flag_cap = false;
    let flag_hit = false;
    let flag_hit_extra = false;

    // Atualiza estrutura de captions
    pc_menu_list.forEach((item, index) => {
      if (item.classList.contains('pc-caption')) {
        if (flag_hit_extra && flag_item_extra.insertAdjacentHTML) {
          const menuicon = flag_item_extra.children[1]
            ? `<span class="pc-micon">${flag_item_extra.children[1].outerHTML}</span>`
            : '';

          flag_item_extra.insertAdjacentHTML(
            'afterend',
            `<li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">
                ${menuicon}
                <span class="pc-mtext">${flag_item_extra.children[0].innerHTML}</span>
                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
              </a>
              <ul class="pc-submenu">${pc_new_list}</ul>
            </li>`
          );
          flag_item_extra.remove();
        }

        flag_hit_extra = true;
        pc_new_list = '';
        flag_hit = false;
        flag_item_extra = item;

        if (pc_menu_list[index + 1] && pc_menu_list[index + 1].classList.contains('pc-caption')) {
          flag_item_extra.remove();
          pc_new_list = '';
          pc_sing_link = '';
          flag_item = '';
          flag_item_extra = '';
          flag_w = 0;
          flag_cap = false;
          flag_hit = false;
          flag_hit_extra = false;
        }
      } else {
        if (!flag_hit) {
          pc_sing_link = flag_item;
          flag_hit = true;
        }

        pc_new_list += item.outerHTML;
        if (index + 1 === pc_menu_list.length && flag_hit_extra && flag_item_extra.insertAdjacentHTML) {
          flag_item_extra.insertAdjacentHTML(
            'afterend',
            `<li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">
                <span class="pc-micon">${flag_item_extra.children[1]?.outerHTML || ''}</span>
                <span class="pc-mtext">${flag_item_extra.children[0].innerHTML}</span>
                <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
              </a>
              <ul class="pc-submenu">${pc_new_list}</ul>
            </li>`
          );
          flag_item_extra.remove();
        }

        if (flag_hit_extra) item.remove();
      }
    });

    const pc_menu_list_new = document.querySelectorAll('.pc-navbar > li.pc-item');
    pc_menu_list_new.forEach((item, index) => {
      flag_w += get_w(item) + 49;
      if (flag_w > window.innerWidth) {
        if (!flag_hit) {
          pc_sing_link = flag_item;
          flag_hit = true;
        }
        if (flag_hit) {
          pc_new_list += item.outerHTML;
          item.remove();
        }
      } else {
        flag_item = item;
      }
      if (index + 1 === pc_menu_list_new.length && pc_sing_link.insertAdjacentHTML) {
        pc_sing_link.insertAdjacentHTML(
          'afterend',
          `<li class="pc-item pc-hasmenu">
            <a href="#!" class="pc-link">
              <span class="pc-micon"><svg class="pc-icon"><use xlink:href="#custom-clipboard"></use></svg></span>
              <span class="pc-mtext">Outros</span>
              <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
            </a>
            <ul class="pc-submenu">${pc_new_list}</ul>
          </li>`
        );
      }
    });

    // Remove classes antigas
    const triggers = document.querySelectorAll('.pc-navbar .pc-trigger');
    triggers.forEach((item) => {
      item.classList.remove('pc-trigger', 'active');
      if (item.children[1]) item.children[1].removeAttribute('style');
    });

    feather.replace();
    const sidebar = document.querySelector('.pc-sidebar');
    if (sidebar) sidebar.classList.remove('d-none');
  }

  // 🔹 Define bordas de submenu (limite lateral da tela)
  function set_edge_menu() {
    const sub_links = document.querySelectorAll('.pc-sidebar .pc-navbar .pc-hasmenu');
    sub_links.forEach((c) => {
      c.addEventListener('mouseenter', collapse_edge);
      c.addEventListener('mouseleave', function (event) {
        const submenu = event.currentTarget.children[1];
        if (submenu) submenu.classList.remove('edge', 'edge-alt', 'edge-alt-full');
      });
    });
  }

  // 🔹 Largura do elemento
  function get_w(element) {
    return element.getBoundingClientRect().width;
  }

  // 🔹 Controla exibição dos submenus (evita "estourar" tela)
  function collapse_edge(event) {
    const docH = window.innerHeight;
    const docW = window.innerWidth;

    if (docW > 1024) {
      const targetElement = event.currentTarget;
      const elm = targetElement.children[1];
      if (!elm) return;

      const off = elm.getBoundingClientRect();
      const { left: l, top: t, width: w, height: h } = off;

      if (l + w > docW) elm.classList.add('edge');
      if (t + h > docH) {
        elm.classList.add('edge-alt');
        if (t < h) {
          elm.classList.add('edge-alt-full');
          const drp_t = t - 140;
          const drp_b = docH - t - 140;
          elm.style.top = `-${drp_t}px`;
          elm.style.bottom = `-${drp_b}px`;
        }
      }
    }
  }
})();
