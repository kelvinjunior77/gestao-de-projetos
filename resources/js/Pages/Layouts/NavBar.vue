<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import logo from '@images/logo-white.svg';
import logoLight from '@images/favicon.svg';

/// estado reativo do path atual
const currentPath = ref(window.location.pathname || '/')

// atualiza currentPath quando Inertia muda a página (fallback)
const page = usePage()

// atualiza quando o histórico do navegador muda (back/forward)
function onPopState() {
    currentPath.value = window.location.pathname || '/'
}

onMounted(() => {
    window.addEventListener('popstate', onPopState)

    // também observa page.url se disponível (Inertia)
    if (page && page.url) {
        // caso page.url mude via Inertia, atualizamos
        currentPath.value = page.url.startsWith('/') ? page.url : new URL(page.url).pathname
    }
})

onBeforeUnmount(() => {
    window.removeEventListener('popstate', onPopState)
})

// função que retorna classes (string)
// aplica border-l-4 border-l-blue-900 quando ativo
function linkClass(path) {
    const base = ['pc-item']
    const inactive = 'pc-item'
    const activeBorder = 'home'

    // considera ativo quando currentPath começa com path
    // ex: /projetos/123 considera /projetos ativo
    const isActive = currentPath.value === path || currentPath.value.startsWith(path + (path === '/' ? '' : '/'))

    return isActive ? `${base} ${activeBorder}` : `${base} ${inactive}`
}

</script>


<template>
    <nav class="pc-sidebar">
        <div class="navbar-wrapper ">
            <div class="m-header flex items-center py-4 px-6 h-header-height">
                <a href="../dashboard/index.html" class="b-brand flex items-center gap-3">
                    <!-- ========   Change your logo from here   ============ -->
                    <img :src="logo" class="img-fluid logo logo-lg" alt="logo" />

                    <img :src="logoLight" class="img-fluid logo logo-sm" alt="logo" />
                </a>
            </div>
            <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
                <ul class="pc-navbar">
                    <li class="pc-item pc-caption">
                        <label>Navegação</label>
                    </li>
                    <!---- class="pc-item home"-->
                    <li :class="linkClass('/admin/dashboard')">
                        <Link href="/admin/dashboard" class="pc-link">
                        <span class="pc-micon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-house-icon lucide-house">
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                                <path
                                    d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            </svg>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                        </Link>
                    </li>
                    <!------
                    <li class="pc-item pc-hasmenu">
                        <Link href="/admin/cadastrar/usuario" class="pc-link">
                            <span class="pc-micon"> <i data-feather="edit"></i></span>
                            <span class="pc-mtext">Color</span>
                        </Link>
                    </li>------>

                    <li class="pc-item pc-caption" v-if="$page.props.auth.user.tipo === 'admin'">
                        <label>Usuarios</label>
                        <i data-feather="feather"></i>
                    </li>
                    <li class="pc-item pc-hasmenu" v-if="$page.props.auth.user.tipo === 'admin'">

                        <Link :class="linkClass('/admin/cadastrar/usuario')" href="/admin/cadastrar/usuario" class="pc-link"><span class="pc-micon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-user-round-plus-icon lucide-user-round-plus">
                                <path d="M2 21a8 8 0 0 1 13.292-6" />
                                <circle cx="10" cy="8" r="5" />
                                <path d="M19 16v6" />
                                <path d="M22 19h-6" />
                            </svg>
                        </span><span class="pc-mtext">Cadastrar</span><span class="pc-arrow">
                        </span>
                        </Link>

                    </li>


                    <li class="pc-item pc-hasmenu">
                        <a href="../elements/bc_color.html" class="pc-link">
                            <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-users-round-icon lucide-users-round">
                                    <path d="M18 21a8 8 0 0 0-16 0" />
                                    <circle cx="10" cy="8" r="5" />
                                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                                </svg></span>

                            <span class="pc-mtext">Desenvolvedores</span>
                        </a>
                    </li>


                    <li class="pc-item pc-caption">
                        <label>Projetos</label>
                        <i data-feather="monitor"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#trstr" class="pc-link"><span class="pc-micon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-folder-kanban-icon lucide-folder-kanban">
                                    <path
                                        d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                                    <path d="M8 10v4" />
                                    <path d="M12 10v2" />
                                    <path d="M16 10v6" />
                                </svg>

                            </span><span class="pc-mtext">Adicionar</span><span class="pc-arrow"></span></a>

                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../pages/register-v1.html" class="pc-link" target="_blank">
                            <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-folder-git2-icon lucide-folder-git-2">
                                    <path
                                        d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                                    <circle cx="13" cy="12" r="2" />
                                    <path d="M18 19c-2.8 0-5-2.2-5-5v8" />
                                    <circle cx="20" cy="19" r="2" />
                                </svg></span>
                            <span class="pc-mtext">Projetos</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <label>Tarefas</label>
                        <i data-feather="monitor"></i>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../pages/register-v1.html" class="pc-link" target="_blank">
                            <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-clipboard-list-icon lucide-clipboard-list">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <path d="M12 11h4" />
                                    <path d="M12 16h4" />
                                    <path d="M8 11h.01" />
                                    <path d="M8 16h.01" />
                                </svg></span>
                            <span class="pc-mtext">Adicionar</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="../pages/register-v1.html" class="pc-link" target="_blank">
                            <span class="pc-micon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-clipboard-list-icon lucide-clipboard-list">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <path d="M12 11h4" />
                                    <path d="M12 16h4" />
                                    <path d="M8 11h.01" />
                                    <path d="M8 16h.01" />
                                </svg></span>
                            <span class="pc-mtext">Tarefas</span>
                        </a>
                    </li>

                    <li class="pc-item pc-caption">
                        <label>Other</label>
                        <i data-feather="sidebar"></i>
                    </li>

                    <li class="pc-item">
                        <a href="../other/sample-page.html" class="pc-link">
                            <span class="pc-micon">
                                <i data-feather="sidebar"></i>
                            </span>
                            <span class="pc-mtext">Pagina Simples</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.home {
    border-left: #079bdf 4px solid;
}
</style>