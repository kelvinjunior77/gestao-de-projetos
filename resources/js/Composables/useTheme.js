// resources/js/composables/useTheme.js
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

export default function useTheme() {
  // 🟢 Proteção contra SSR (caso o código rode antes do DOM existir)
  if (typeof window === 'undefined' || typeof document === 'undefined') {
    const theme = ref('light');
    const isDark = ref(false);
    return {
      theme,
      isDark,
      setTheme: () => {},
      toggleTheme: () => {},
      initTheme: () => {},
      destroy: () => {},
      currentTheme: ref('light'),
    };
  }

  const STORAGE_KEY = 'theme'; // 'light' | 'dark' | 'system'
  const prefersDarkMq = window.matchMedia
    ? window.matchMedia('(prefers-color-scheme: dark)')
    : null;

  // 🟢 Singleton para evitar múltiplos listeners se o composable for usado várias vezes
  let listenerRegistered = false;

  const theme = ref('system'); // 'light' | 'dark' | 'system'

  const isDark = computed(() => {
    if (theme.value === 'system') {
      return prefersDarkMq ? prefersDarkMq.matches : false;
    }
    return theme.value === 'dark';
  });

  // Novo: modo efetivo (light/dark), mesmo que o tema seja "system"
  const currentTheme = computed(() => (isDark.value ? 'dark' : 'light'));

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
      console.warn('Erro ao acessar localStorage:', e);
    }
  }

  // 🟢 Ajuste: aplica o tema com base no valor atualizado (sem depender do computed)
  function setTheme(value) {
    if (!['light', 'dark', 'system'].includes(value)) value = 'system';
    theme.value = value;
    persist(value);

    const darkNow =
      value === 'dark' ||
      (value === 'system' && prefersDarkMq && prefersDarkMq.matches);
    applyHtmlClass(darkNow);
  }

  function toggleTheme() {
    if (theme.value === 'system') {
      setTheme(prefersDarkMq && prefersDarkMq.matches ? 'light' : 'dark');
      return;
    }
    setTheme(theme.value === 'dark' ? 'light' : 'dark');
  }

  function handlePrefChange(e) {
    if (theme.value === 'system') {
      applyHtmlClass(e.matches);
    }
  }

  function initTheme() {
    try {
      const saved = localStorage.getItem(STORAGE_KEY);
      if (saved === 'light' || saved === 'dark' || saved === 'system') {
        theme.value = saved;
      } else {
        theme.value = 'system';
      }
    } catch (e) {
      theme.value = 'system';
    }

    applyHtmlClass(isDark.value);

    // 🟢 Evita registrar listener múltiplas vezes
    if (!listenerRegistered && prefersDarkMq) {
      if (typeof prefersDarkMq.addEventListener === 'function') {
        prefersDarkMq.addEventListener('change', handlePrefChange);
      } else if (typeof prefersDarkMq.addListener === 'function') {
        prefersDarkMq.addListener(handlePrefChange);
      }
      listenerRegistered = true;
    }
  }

  function destroy() {
    if (listenerRegistered && prefersDarkMq) {
      if (typeof prefersDarkMq.removeEventListener === 'function') {
        prefersDarkMq.removeEventListener('change', handlePrefChange);
      } else if (typeof prefersDarkMq.removeListener === 'function') {
        prefersDarkMq.removeListener(handlePrefChange);
      }
      listenerRegistered = false;
    }
  }

  onMounted(() => initTheme());
  onBeforeUnmount(() => destroy());

  return {
    theme,
    isDark,
    currentTheme, // 🆕 Retorna modo efetivo
    setTheme,
    toggleTheme,
    initTheme,
    destroy,
  };
}
