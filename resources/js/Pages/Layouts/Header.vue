<script setup>
import { ref, onMounted } from "vue";
import { Link, usePage, router } from '@inertiajs/vue3';

// Dados do usuário
const user = usePage().props.auth.user ?? {
  name: "User",
  email: "user@example.com",
  avatar_url: "https://i.pravatar.cc/150"
};

// Notificações fake
const notifications = ref(3);

// Dropdowns
const dSearch = ref(false);

const dSettings = ref(false);
const dNotify = ref(false);
const dProfile = ref(false);

// Fecha todos os dropdowns
function closeAll() {
  dSearch.value = false;
  dSettings.value = false;
  dNotify.value = false;
  dProfile.value = false;
}

const currentTheme = ref("light");

// Carrega o tema salvo
onMounted(() => {
  const saved = localStorage.getItem("theme");
  currentTheme.value = saved || "light";
  document.documentElement.setAttribute("data-theme", currentTheme.value);
});

// Alterna entre claro/escuro
const toggleTheme = () => {
  currentTheme.value = currentTheme.value === "light" ? "dark" : "light";
  document.documentElement.setAttribute("data-theme", currentTheme.value);
  localStorage.setItem("theme", currentTheme.value);
};


// Logout
function logout() {
  router.post(route('logout'));
}
</script>

<template>
  <header class="navbar bg-base-100 shadow-sm sticky top-0 z-40 px-4">
    <!-- LEFT -->
    <div class="navbar-start gap-2">

      <!-- Mobile toggle -->
      <button class="btn btn-ghost btn-circle lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </button>

      <!-- Desktop toggle -->
      <button class="btn btn-ghost btn-circle hidden lg:flex">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- SEARCH DROPDOWN -->
      <div class="dropdown" @click.stop="closeAll(); dSearch = !dSearch">
        <button class="btn btn-ghost btn-circle">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </button>

        <div v-show="dSearch" class="dropdown-content z-50 mt-3 w-64 p-3 bg-base-100 border rounded-box shadow">
          <input type="text" placeholder="Pesquisar..." class="input input-bordered w-full" />
        </div>
      </div>

    </div>

    <!-- RIGHT -->
    <div class="navbar-end gap-1">

      <button class="btn btn-ghost btn-circle" @click="toggleTheme" title="Mudar Tema">
        <!-- Ícone do Sol (tema claro) -->
        <svg v-if="currentTheme === 'light'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
          stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="4"></circle>
          <path d="M12 2v2"></path>
          <path d="M12 20v2"></path>
          <path d="m4.93 4.93 1.41 1.41"></path>
          <path d="m17.66 17.66 1.41 1.41"></path>
          <path d="M2 12h2"></path>
          <path d="M20 12h2"></path>
        </svg>

        <!-- Ícone da Lua (tema escuro) -->
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor"
          stroke-width="2">
          <path d="M21 12.79A9 9 0 1 1 11.21 3
           7 7 0 0 0 21 12.79z">
          </path>
        </svg>
      </button>


      <!-- NOTIFICAÇÕES -->
      <div class="dropdown dropdown-end" @click.stop="closeAll(); dNotify = !dNotify">
        <button class="btn btn-ghost btn-circle">
          <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.4-1.4A2 2 0 0118 14v-3a6 6 0 00-9.3-5" />
            </svg>
            <span v-if="notifications" class="badge badge-xs badge-error indicator-item"></span>
          </div>
        </button>

        <div v-show="dNotify"
          class="dropdown-content z-50 mt-3 w-72 bg-base-100 border rounded-box shadow max-h-80 overflow-y-auto p-3">
          <h3 class="font-bold mb-2">Notificações</h3>
          <p class="text-sm opacity-70">Nenhuma notificação nova.</p>
        </div>
      </div>

      <!-- USER DROPDOWN -->
      <div class="dropdown dropdown-end" @click.stop="closeAll(); dProfile = !dProfile">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img :src="user.avatar_url" />
          </div>
        </div>

        <ul v-show="dProfile" class="dropdown-content z-50 mt-3 w-56 bg-base-100 border rounded-box shadow p-2">
          <li class="px-3 py-2 border-b">
            <div class="font-bold">{{ user.name }}</div>
            <div class="text-xs opacity-70">{{ user.email }}</div>
          </li>
          <li><a href="">Minha Conta</a></li>
          <li><button @click="logout" class="text-error">Sair</button></li>
        </ul>
      </div>

    </div>
  </header>

  <!-- FECHAR DROPDOWNS AO CLICAR FORA -->
  <div @click="closeAll"></div>
</template>
