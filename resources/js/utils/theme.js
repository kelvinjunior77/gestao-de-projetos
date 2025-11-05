// resources/js/utils/theme.js
export function layout_change(mode = 'light') {
  document.documentElement.classList.toggle('dark', mode === 'dark');
  localStorage.setItem('theme', mode);
}

export function layout_theme_sidebar_change(dark = true) {
  const sidebar = document.querySelector('.sidebar');
  if (sidebar) sidebar.classList.toggle('dark-sidebar', dark === true);
}

export function change_box_container(boxed = false) {
  const container = document.querySelector('.main-container');
  if (container) container.classList.toggle('boxed', boxed === true);
}

export function layout_caption_change(show = true) {
  const captions = document.querySelectorAll('.caption');
  captions.forEach(el => el.style.display = show ? 'block' : 'none');
}

export function layout_rtl_change(isRtl = false) {
  document.documentElement.dir = isRtl ? 'rtl' : 'ltr';
}

export function preset_change(name = 'preset-1') {
  document.body.setAttribute('data-preset', name);
}

export function main_layout_change(type = 'vertical') {
  document.body.setAttribute('data-layout', type);
}
