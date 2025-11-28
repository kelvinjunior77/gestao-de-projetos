<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

// Seus logos (ajuste os caminhos conforme necessário)
// import logo from '@images/logo-dark.svg'; 
// import logoLight from '@images/logo-light.svg';

// Simulação de logos para visualização
const logo = 'https://placehold.co/120x30?text=Datta+Able';

const page = usePage();

// Função simplificada para gerar classes
// Usa a URL atual do Inertia diretamente, que é reativa
const getLinkClass = (path) => {
    const currentUrl = page.url;

    // Verifica se é a URL exata ou se é uma sub-rota (ex: /projetos/criar ativa /projetos)
    const isActive = currentUrl === path || currentUrl.startsWith(path + '/');

    // Estilos Base (Layout, Espaçamento, Transição)
    const baseClasses = 'flex items-center gap-3 py-3 px-5 hover:bg-base-200 transition-all duration-200 group';

    // Estilo Ativo (Borda Azul, Fundo sutil, Texto colorid)
    const activeClasses = 'border-l-4 border-primary bg-primary/5 text-primary font-medium';

    // Estilo Inativo (Borda transparente para manter alinhamento, Texto cinza)
    const inactiveClasses = 'border-l-4 border-transparent text-base-content/70 hover:text-base-content';

    return isActive ? `${baseClasses} ${activeClasses}` : `${baseClasses} ${inactiveClasses}`;
};

// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');

const isNormal = computed(() => page.props.auth.user.tipo === 'normal')

</script>

<template>
    <aside
        class="w-64 h-screen bg-base-100 border-r border-base-200 flex flex-col sticky top-0 z-40 shadow-sm overflow-hidden">

        <div class="h-16 flex items-center px-6 border-b border-base-200 shrink-0">
            <Link href="/" class="flex items-center gap-2">
            <!---<img :src="logo" class="h-8 w-auto" alt="Logo do Sistema"/>-->
            <h1 class="text-2xl uppercase font-bold">Dashboard</h1>
            </Link>
        </div>

        <div class="flex-1 overflow-y-auto py-4 custom-scroll">
            <ul class="menu w-full p-0 text-sm">

                <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-2 px-6">
                    Navegação
                </li>

                <li>
                    <Link href="/" :class="getLinkClass('/')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                        <path
                            d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    </svg>
                    <span>Dashboard</span>
                    </Link>
                </li>

                <template v-if="isAdmin">
                    <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-4 px-6">
                        Administração
                    </li>

                    <li>
                        <Link href="/admin/cadastrar/usuario" :class="getLinkClass('/admin/cadastrar/usuario')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <line x1="20" x2="20" y1="8" y2="14" />
                            <line x1="23" x2="17" y1="11" y2="11" />
                        </svg>
                        <span>Desenvolvedor</span>
                        </Link>
                    </li>

                    <li>
                        <Link href="/admin/listar/usuarios" :class="getLinkClass('/admin/listar/usuarios')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Desenvolvedores</span>
                        </Link>
                    </li>

                </template>

                <template v-if="isNormal">

                    <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-4 px-6">
                        Usuarios
                    </li>
                    <li>
                        <Link href="/lista/usuarios" :class="getLinkClass('/lista/usuarios')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Desenvolvedores</span>
                        </Link>
                    </li>
                </template>


                <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-4 px-6">
                    Projetos
                </li>

                <li>
                    <Link href="/projetos/criar" :class="getLinkClass('/projetos/criar')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                        <path d="M20 9v11" />
                        <path d="M10 3v6a2 2 0 0 1-2 2H4" />
                        <path d="M16 14h2" />
                        <path d="M16 10h2" />
                        <path d="M16 18h2" />
                    </svg>
                    <span>Novo Projeto</span>
                    </Link>
                </li>
                <li>
                    <Link href="/projetos" :class="getLinkClass('/projetos')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                        <circle cx="12" cy="10" r="2" />
                    </svg>
                    <span>Meus Projetos</span>
                    </Link>
                </li>


                <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-4 px-6">
                    Tarefas
                </li>

                <li>
                    <Link href="/tarefas/criar" :class="getLinkClass('/tarefas/criar')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                        <path d="M12 11h4" />
                        <path d="M12 16h4" />
                        <path d="M8 11h.01" />
                        <path d="M8 16h.01" />
                    </svg>
                    <span>Adicionar Tarefa</span>
                    </Link>
                </li>
                <li>
                    <Link href="/tarefas" :class="getLinkClass('/tarefas')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 2v4" />
                        <path d="M16 2v4" />
                        <rect width="18" height="18" x="3" y="4" rx="2" />
                        <path d="M3 10h18" />
                        <path d="M9 16l2 2 4-4" />
                    </svg>
                    <span>Minhas Tarefas</span>
                    </Link>
                </li>

                <template v-if="isAdmin">
                    <li class="menu-title uppercase text-xs font-bold text-base-content/40 mt-4 px-6">
                        Habilidades - Cargos
                    </li>
                    <li>
                        <Link href="/pagina-simples" :class="getLinkClass('/pagina-simples')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                            <line x1="9" x2="9" y1="3" y2="21" />
                        </svg>
                        <span>Cadastrar</span>
                        </Link>
                    </li>

                    <li>
                        <Link href="/pagina-simples" :class="getLinkClass('/pagina-simples')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                            <line x1="9" x2="9" y1="3" y2="21" />
                        </svg>
                        <span>Cargos</span>
                        </Link>
                    </li>
                </template>

            </ul>
        </div>
    </aside>
</template>

<style scoped>
/* Personalização opcional da barra de rolagem para ficar fina e elegante */
.custom-scroll::-webkit-scrollbar {
    width: 5px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    /* gray-200 */
    border-radius: 10px;
}

.custom-scroll:hover::-webkit-scrollbar-thumb {
    background: #d1d5db;
    /* gray-300 */
}
</style>