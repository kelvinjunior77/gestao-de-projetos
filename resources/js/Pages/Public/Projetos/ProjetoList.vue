<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import Layout from "../../Layouts/Layout.vue";

const props = defineProps({
    projetos: Object,
    filtros: Object,
});

// Filtros reativos
const search = ref(props.filtros.search || "");
const prioridade = ref(props.filtros.prioridade || "");
const visibilidade = ref(props.filtros.visibilidade || "");


// Atualiza listagem sempre que filtro mudar
watch([search, prioridade, visibilidade], () => {
    applyFilters();
});
// Envia filtros para a rota
/** 
const filtrar = () => {
    router.get("/projetos",
        {
            search: search.value,
            prioridade: prioridade.value,
            visibilidade: visibilidade.value,
        },
        { preserveState: true, preserveScroll: true }
    );
}; */

// Função de filtros admin
function applyFilters(page = 1) {
    router.get(
        "/projetos",
        {
            search: search.value,
            prioridade: prioridade.value,
            visibilidade: visibilidade.value,
            page,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

// Paginação corrigida
function goTo(link) {
    if (!link.url) return;

    // extrai "page" da URL (...?page=3)
    const urlObj = new URL(link.url);
    const pageNumber = urlObj.searchParams.get("page");

    applyFilters(pageNumber);
    //applyFiltersNormal(pageNumber);
}

// Refiltra automaticamente quando mudar prioridade ou visibilidade
//watch([prioridade, visibilidade], filtrar);
</script>

<template>
    <Layout>

        <div class="max-w-10xl h-10 mb-6">
            <div
                class="flex flex-col md:flex-row md:items-center justify-between bg-base-100 border border-base-200 rounded-xl px-1 py-1 shadow-sm">
                <!-- Título -->
                <div>

                    <!-- Breadcrumb -->
                    <nav class="text-sm breadcrumbs mt-1 p-2 opacity-70">
                        <ul>
                            <li>
                                <Link href="/">
                                    Home
                                </Link>
                            </li>

                            <li class="font-medium text-primary">
                                Lista de Projetos
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

    
        <!-- FILTROS -->
        <div class="flex gap-4 mb-6">

            <!-- Busca -->
             
                <input type="text" v-model="search" @keyup.enter="filtrar" class="input input-bordered  outline-0 w-full"
                placeholder="Buscar por título..." />
            
            

            <!-- Prioridade -->
            <select v-model="prioridade" class="select select-bordered outline-0 w-50">
                <option value="">Todas prioridades</option>
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
            </select>

            <!-- Visibilidade -->
            <select v-model="visibilidade" class="select select-bordered outline-0 w-50">
                <option value="">Todas visibilidades</option>
                <option value="publico">Público</option>
                <option value="privado">Privado</option>
            </select>

                <Link class="btn btn-success w-33">Meus Projetos</Link>
         
                <Link class="btn btn-primary w-33">Criar Projeto</Link>
           

        </div>

        <!-- LISTA DE PROJETOS -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body">

                <!-- Se não existir projetos -->
                <p v-if="projetos.data.length === 0" class="text-center py-6 opacity-60">
                    Nenhum projeto encontrado.
                </p>

                <!-- TABELA -->
                <div v-else class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Github</th>
                                <th>Prioridade</th>
                                <th>Visibilidade</th>
                                <th>Criado por</th>
                                <th>Data Final</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="projeto in projetos.data" :key="projeto.id">

                                <td>
                                    <span class="font-bold text-info">{{ projeto.nome }}</span>
                                </td>

                                <td>
                                    <a v-if="projeto.github" :href="projeto.github" class="text-primary underline"
                                        target="_blank">
                                        Link
                                    </a>
                                    <span v-else class="opacity-50">—</span>
                                </td>

                                <td class="capitalize">
                                    <span :class="{
                                        'badge badge-soft badge-error': projeto.prioridade === 'alta',
                                        'badge badge-soft badge-warning': projeto.prioridade === 'média',
                                        'badge badge-soft badge-success': projeto.prioridade === 'baixa',
                                    }">
                                        {{ projeto.prioridade }}
                                    </span>

                                </td>

                                <td class="capitalize">

                                    <span :class="{
                                        'badge badge-soft badge-accent': projeto.visibilidade === 'publico',
                                        'badge badge-ghost': projeto.visibilidade === 'privado',
                                    }"> {{ projeto.visibilidade }}</span>
                                </td>

                                <td>
                                    {{ projeto.user?.name || '—' }}
                                </td>

                                <td>
                                    {{ projeto.data_fim ?? '—' }}
                                </td>

                                <td class="flex gap-2">
                                    <Link :href="`/admin/editar/projeto/${projeto.id}`" class="btn btn-sm btn-info">
                                        Editar
                                    </Link>

                                    <Link :href="`/admin/excluir/projeto/${projeto.id}`" method="delete" as="button"
                                        class="btn btn-sm btn-error">
                                        Excluir
                                    </Link>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!-- PAGINAÇÃO -->
                <div class="flex justify-between items-center mt-6">

                    <p class="text-sm opacity-70">
                        Página {{ projetos.current_page }} de {{ projetos.last_page }}
                    </p>

                    <div class="join">
                        <button v-for="(link, index) in projetos.links" :key="index" class="btn join-item" :class="{
                            'btn-primary': link.active,
                            'btn-ghost': !link.active,
                            'pointer-events-none opacity-40': link.url === null
                        }" v-html="link.label" @click="goTo(link)"></button>
                    </div>

                </div>

            </div>
        </div>

    </Layout>
</template>
