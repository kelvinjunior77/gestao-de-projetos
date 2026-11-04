import { ref, computed, onMounted, watch } from 'vue';

/**
 * Composable global para controle de tema e layout
 * Funciona com Laravel + Vue + Inertia + Datta Able
 */
export function useTheme() {
  // 🧱 Chaves do localStorage
  const STORAGE = {
    theme: 'app_theme',            // 'light' | 'dark' | 'system'
    layout: 'app_layout',          // 'vertical' | 'horizontal' | 'compact' | 'tab'
    sidebar: 'app_sidebar_open',   // 'true' | 'false'
  };

  // 🔹 Estado
  const theme = ref(localStorage.getItem(STORAGE.theme) || 'system');
  const layout = ref(localStorage.getItem(STORAGE.layout) || 'vertical');
  const sidebarOpen = ref(localStorage.getItem(STORAGE.sidebar) === 'true');

  // 🔹 Computed
  const isDark = computed(() => {
    if (theme.value === 'system') {
      return window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    return theme.value === 'dark';
  });

  // ✅ Aplica tema no <html>
  const applyTheme = () => {
    const html = document.documentElement;
    if (isDark.value) {
      html.classList.add('dark');
      html.setAttribute('data-theme', 'dark');
    } else {
      html.classList.remove('dark');
      html.setAttribute('data-theme', 'light');
    }
  };

  // ✅ Aplica layout no <html>
  const applyLayout = () => {
    const html = document.documentElement;
    html.setAttribute('data-pc-layout', layout.value);
  };

  // ✅ Aplica estado da sidebar
  const applySidebar = () => {
    const body = document.body;
    if (sidebarOpen.value) {
      body.classList.remove('pc-sidebar-hide');
    } else {
      body.classList.add('pc-sidebar-hide');
    }
  };

  // 🔹 Alterações e persistência
  watch(theme, (val) => {
    localStorage.setItem(STORAGE.theme, val);
    applyTheme();
  });

  watch(layout, (val) => {
    localStorage.setItem(STORAGE.layout, val);
    applyLayout();
  });

  watch(sidebarOpen, (val) => {
    localStorage.setItem(STORAGE.sidebar, val);
    applySidebar();
  });

  // 🔹 Alterna entre claro e escuro
  const toggleTheme = () => {
    theme.value = isDark.value ? 'light' : 'dark';
  };

  // 🔹 Alterna estado da sidebar
  const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
  };

  // 🔹 Inicialização
  const initTheme = () => {
    applyTheme();
    applyLayout();
    applySidebar();
  };

  onMounted(initTheme);

  return {
    theme,
    layout,
    sidebarOpen,
    isDark,
    toggleTheme,
    toggleSidebar,
    setTheme: (val) => (theme.value = val),
    setLayout: (val) => (layout.value = val),
    initTheme,
  };
}
