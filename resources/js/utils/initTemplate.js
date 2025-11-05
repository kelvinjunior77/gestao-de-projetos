// resources/js/utils/initTemplate.js
export async function initTemplate() {
  if (typeof window === 'undefined' || typeof document === 'undefined') return;

  console.info('[initTemplate] Verificando layout e recarregando scripts...');

  try {
    const html = document.documentElement;
    const layout = html.getAttribute('data-pc-layout') || 'vertical';

    // 🔹 Caminho base dos scripts do template
    const base = '/assets/js/';

    // 🔹 Mapeamento dos layouts
    const layoutScripts = {
      horizontal: `${base}layout-horizontal.js`,
      compact: `${base}layout-compact.js`,
      tab: `${base}layout-tab.js`,
      vertical: `${base}script.js`, // fallback
    };

    // 🔹 Carrega script base do template
    await loadScript(`${base}script.js`);

    // 🔹 Carrega script específico do layout (se existir)
    if (layoutScripts[layout]) {
      await loadScript(layoutScripts[layout]);
      console.info(`[initTemplate] Layout "${layout}" carregado.`);
    } else {
      console.warn(`[initTemplate] Layout "${layout}" não reconhecido. Usando padrão.`);
    }

    // 🔹 Reaplica comportamentos
    refreshTemplateUI();

  } catch (error) {
    console.error('[initTemplate] Erro ao recarregar scripts:', error);
  }
}

// Função auxiliar para carregar scripts dinamicamente
function loadScript(src) {
  return new Promise((resolve, reject) => {
    if (document.querySelector(`script[src="${src}"]`)) {
      // Já carregado
      return resolve();
    }

    const script = document.createElement('script');
    script.src = src;
    script.async = true;
    script.onload = () => resolve();
    script.onerror = () => reject(new Error(`Erro ao carregar ${src}`));
    document.body.appendChild(script);
  });
}

// Reaplica ícones, menus e efeitos do template
function refreshTemplateUI() {
  console.info('[initTemplate] Reaplicando interações do template...');

  try {
    // Feather icons
    if (window.feather) {
      window.feather.replace();
    }

    // Menus
    if (typeof window.menu_click === 'function') {
      window.menu_click();
    }

    // Scrollbars (SimpleBar)
    if (window.SimpleBar) {
      document.querySelectorAll('.navbar-content, .header-notification-scroll, .profile-notification-scroll')
        .forEach((el) => {
          if (!el.SimpleBarInstance) new window.SimpleBar(el);
        });
    }

    // Tooltips e popovers
    if (window.bootstrap) {
      document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
        new window.bootstrap.Tooltip(el);
      });
      document.querySelectorAll('[data-bs-toggle="popover"]').forEach((el) => {
        new window.bootstrap.Popover(el);
      });
    }

    console.info('[initTemplate] UI atualizada.');

  } catch (error) {
    console.error('[initTemplate] Falha ao aplicar interações:', error);
  }
}
