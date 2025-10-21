// resources/js/composables/useTheme.js
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const STORAGE_KEY = 'theme'; // 'light' | 'dark' | 'system'
const prefersDarkMq = window.matchMedia ? window.matchMedia('(prefers-color-scheme: dark)') : null;

export default function useTheme() {
  const theme = ref('system'); // 'light' | 'dark' | 'system'
  const isDark = computed(() => {
    if (theme.value === 'system') {
      return prefersDarkMq ? prefersDarkMq.matches : false;
    }
    return theme.value === 'dark';
  });

  // Aplica a classe 'dark' no <html> de acordo com isDark
  function applyHtmlClass(dark) {
    const html = document.documentElement;
    if (dark) {
      html.classList.add('dark');
      html.setAttribute('data-theme', 'dark');
    } else {
      html.classList.remove('dark');
      html.setAttribute('data-theme', 'light');
    }
  }

  function persist(value) {
    try {
      localStorage.setItem(STORAGE_KEY, value);
    } catch (e) {
      // storage pode falhar em contextos restritos; silenciar
      console.warn('Erro ao acessar localStorage:', e);
    }
  }

  function setTheme(value) {
    if (!['light', 'dark', 'system'].includes(value)) value = 'system';
    theme.value = value;
    persist(value);
    applyHtmlClass(isDark.value);
  }

  function toggleTheme() {
    // Alterna entre light <-> dark; se estiver em system, força para opposite do sistema
    if (theme.value === 'system') {
      // se system, toggla para opposite da preferência atual
      setTheme(prefersDarkMq && prefersDarkMq.matches ? 'light' : 'dark');
      return;
    }
    setTheme(theme.value === 'dark' ? 'light' : 'dark');
  }

  // listener pra mudanças na preferência do sistema (só importa se estiver em 'system')
  function handlePrefChange(e) {
    if (theme.value === 'system') {
      applyHtmlClass(e.matches);
    }
  }

  // Inicializa estado a partir do localStorage / preferencia do sistema
  function initTheme() {
    try {
      const saved = localStorage.getItem(STORAGE_KEY);
      if (saved === 'light' || saved === 'dark' || saved === 'system') {
        theme.value = saved;
      } else {
        // Se não existia, usa 'system' como padrão (pode mudar pra 'light' se preferir)
        theme.value = 'system';
      }
    } catch (e) {
      theme.value = 'system';
    }

    // aplica a classe inicial
    applyHtmlClass(isDark.value);

    // registra listener
    if (prefersDarkMq && typeof prefersDarkMq.addEventListener === 'function') {
      prefersDarkMq.addEventListener('change', handlePrefChange);
    } else if (prefersDarkMq && typeof prefersDarkMq.addListener === 'function') {
      // para compatibilidade
      prefersDarkMq.addListener(handlePrefChange);
    }
  }

  function destroy() {
    if (prefersDarkMq && typeof prefersDarkMq.removeEventListener === 'function') {
      prefersDarkMq.removeEventListener('change', handlePrefChange);
    } else if (prefersDarkMq && typeof prefersDarkMq.removeListener === 'function') {
      prefersDarkMq.removeListener(handlePrefChange);
    }
  }

  // Se for usado dentro de setup() podemos auto-montar/desmontar
  onMounted(() => initTheme());
  onBeforeUnmount(() => destroy());

  return {
    theme,
    isDark,
    setTheme,
    toggleTheme,
    initTheme,
    destroy,
  };
}
