<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import { route } from "ziggy-js";

// Dados do usuário
const page = usePage();
const user = page.props.auth.user;

// Notificações fake
const notifications = ref(3);

const dSettings = ref(false);
const dNotify = ref(false);
const dProfile = ref(false);

// Fecha todos os dropdowns
function closeAll() {
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

const notificacoes = computed(() => page.props.notificacoes ?? [])

// Som 
const playSound = () => {
  const audio = new Audio('/sounds/notify.wav')
  audio.volume = 0.5
  audio.play()
}

let oldCount = 0

watch(notificacoes, (newVal) => {
  if (newVal.length > oldCount) {
    playSound()
  }
  oldCount = newVal.length
})

</script>

<template>
  <header class="navbar bg-base-300 shadow-sm sticky top-0 z-40 px-4 mb-0">
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

      <!-- SEARCH DROPDOWN 
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
      </div>-->

    </div>

    <!-- RIGHT -->
    <div class="navbar-end gap-1">

      <button class="btn btn-ghost btn-circle" @click="toggleTheme" title="Mudar Tema">
        <!-- Ícone do Sol (tema claro) -->

        <svg v-if="currentTheme === 'light'" class="swap-off h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24">
          <path
            d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
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
      <div class="dropdown dropdown-end ml-0 mr-3" @click.stop="closeAll(); dNotify = !dNotify">
        <button class="btn btn-ghost btn-circle">
          <div class="indicator">
            <!-- Ícone -->
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-bell-icon lucide-bell">
              <path d="M10.268 21a2 2 0 0 0 3.464 0" />
              <path
                d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
            </svg>

            <!-- Contador -->
            <span v-if="notificacoes.length > 0" class="badge badge-xs badge-error indicator-item"></span>
          </div>
        </button>

        <!-- DROPDOWN -->
        <div v-show="dNotify"
          class="dropdown-content z-50 mt-3 w-80 bg-base-100 border rounded-box shadow max-h-96 overflow-y-auto p-3 animate-fadeIn">

          <div class="flex justify-between items-center mb-3">
            <h3 class="font-bold flex items-center gap-2 mb-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-bell-icon lucide-bell">
                <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                <path
                  d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
              </svg>
              Notificações
            </h3>

            <!-- Botão limpar tudo -->
            <button v-if="notificacoes.length > 0" class="btn btn-xs btn-outline btn-error" @click.stop="limparTodas">
              Limpar
            </button>
          </div>

          <p v-if="notificacoes.length === 0" class="text-sm opacity-70"> Nenhuma notificação nova. </p>

          <!-- Se não houver notificações -->
          <span v-if="notificacoes.length > 0" class="badge badge-ghost mb-2 flex items-center gap-2 text-base-600">
            <div class="status status-info animate-bounce"></div> Novas Tarefas
            <span class="badge">{{ notificacoes.length }}</span>
          </span>


          <!-- LISTA DE NOTIFICAÇÕES -->
          <div v-for="n in notificacoes" :key="n.id" class="mb-2">

            <div
              class="collapse collapse-arrow bg-base-200 border border-base-300 rounded-lg shadow-sm hover:bg-base-300 transition">

              <input type="checkbox" />

              <!-- CABEÇALHO -->
              <div class="collapse-title flex justify-between items-center py-3">

                <div class="flex items-center gap-3">

                  <!-- ÍCONE PERSONALIZADO -->
                  <div class="w-8 h-8 rounded-full flex items-center justify-center" :class="{
                    'bg-blue-500': n.data.funcao === 'Desenvolvimento',
                    'bg-green-500': n.data.funcao === 'Design',
                    'bg-purple-500': n.data.funcao === 'Marketing',
                    'bg-orange-500': n.data.funcao === 'Administração',
                    'bg-gray-500': !n.data.funcao
                  }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="lucide lucide-clipboard-list-icon lucide-clipboard-list">
                      <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                      <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                      <path d="M12 11h4" />
                      <path d="M12 16h4" />
                      <path d="M8 11h.01" />
                      <path d="M8 16h.01" />
                    </svg>
                  </div>

                  <div>
                    <h5 class="font-bold text-sm text-primary">{{ n.data.titulo }}</h5>

                    <!--- <p class="font-semibold text-sm">
                      {{ n.data.titulo }}
                    </p>--->

                    <p class="text-xs opacity-70">
                      Criado por <span class="font-medium">{{ n.data.criador_nome }}</span>
                    </p>
                  </div>
                </div>

                <!-- Botão marcar como lida -->
                <button class="btn btn-xs btn-ghost text-success" @click.stop="marcarComoLida(n.id)"
                  title="Marcar como lida">
                  ✔
                </button>

              </div>

              <!-- CONTEÚDO -->
              <div class="collapse-content text-sm space-y-2">

                <div class="opacity-80">
                  {{ n.data.descricao }}
                </div>

                <div>
                  <span class="badge badge-primary badge-sm">
                    {{ n.data.funcao }}
                  </span>
                </div>

                <div class="text-[10px] opacity-50">
                  {{ new Date(n.created_at).toLocaleString('pt-BR') }}
                </div>

              </div>
            </div>

          </div>


        </div>
      </div>

      <!-- NOTIFICAÇÕES 
      <div class="dropdown dropdown-end ml-0 mr-3" @click.stop="closeAll(); dNotify = !dNotify">
        <button class="btn btn-ghost btn-circle">
          <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-bell-icon lucide-bell">
              <path d="M10.268 21a2 2 0 0 0 3.464 0" />
              <path
                d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
            </svg>
            <span v-if="notifications" class="badge badge-xs badge-error indicator-item">

            </span>
          </div>
        </button>

        <div v-show="dNotify"
          class="dropdown-content z-50 mt-3 w-72 bg-base-100 border rounded-box shadow max-h-80 overflow-y-auto p-3">
          <h3 class="font-bold mb-2">Notificações</h3>
          <p class="text-sm opacity-70">Nenhuma notificação nova.</p>

          <div v-for="n in notificacoes" :key="n.id"> {{ n.data.titulo }} TESTE</div> ssss

        </div>
      </div>
      -->

      <!-- USER DROPDOWN -->
      <div class="dropdown dropdown-end bg-base-200" @click.stop="closeAll(); dProfile = !dProfile">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img v-if="user.avatar" :src="user.avatar" alt="Avatar do usuario" />
          </div>
        </div>

        <ul v-show="dProfile" class="dropdown-content z-50 mt-3 w-56 bg-base-200 rounded-box shadow p-2">
          <li class="px-3 py-2 text-center">
            <div class="font-bold mb-0">{{ user.name }}</div>
            <span class="text-sm mb-4">{{ user.cargo }}</span>
            <div class="text-xs opacity-70 mb-2">
              <span class="badge badge-soft badge-primary">{{ user.email }}</span>
            </div>
            <div class="text-xs opacity-70 mt-1">
              <span class="badge badge-soft badge-primary">{{ user.tipo }}</span>
            </div>
          </li> <br>

          <div class="flex items-center flex-col">
            <li>
              <Link class="btn btn-sm" :href="(route('usuario.perfil', user.slug))">Meu Perfil</Link>
            </li>
            <li class="mt-2">

              <Link method="post" href="/logout" class="text-error cursor-pointer mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="lucide lucide-power-icon lucide-power">
                  <path d="M12 2v10" />
                  <path d="M18.4 6.6a9 9 0 1 1-12.77.04" />
                </svg>

              </Link>
            </li>
          </div>

        </ul>

      </div>

    </div>
  </header>

  <!-- FECHAR DROPDOWNS AO CLICAR FORA -->
  <div @click="closeAll"></div>
</template>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.2s ease-out;
}
</style>