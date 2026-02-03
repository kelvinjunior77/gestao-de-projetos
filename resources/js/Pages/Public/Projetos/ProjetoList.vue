<script setup>
import Layout from "../../Layouts/Layout.vue";
import ProjectViewModal from "../../Modal/ProjectViewModal.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import { route } from 'ziggy-js';

const props = defineProps({
    projetos: Object,
    filtros: Object,
});

// Filtros reativos
const search = ref(props.filtros.search || "");
const prioridade = ref(props.filtros.prioridade || "");
const visibilidade = ref(props.filtros.visibilidade || "");
const autor = ref(props.filtros.autor || "");

// Atualiza listagem sempre que filtro mudar
watch([search, prioridade, visibilidade, autor], () => {
    applyFilters();
});

function applyFilters(page = 1) {
    router.get(
        "/projetos/lista",
        {
            search: search.value,
            prioridade: prioridade.value,
            visibilidade: visibilidade.value,
            autor: autor.value,
            page,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

// Paginação 
function goTo(link) {
    if (!link.url) return;

    // extrai "page" da URL (...?page=3)
    const urlObj = new URL(link.url);
    const pageNumber = urlObj.searchParams.get("page");

    applyFilters(pageNumber);
    //applyFiltersNormal(pageNumber);
}

// modal
const showDeleteModal = ref(false);
const projetoToDelete = ref(null);

// Abre o modal recebendo o usuário
const confirmDelete = (projeto) => {
    projetoToDelete.value = projeto;
    showDeleteModal.value = true;
};

// modal projeto
const showModal = ref(false);
const projetoSelecionado = ref(null);

// Função que recebe o projeto ao clicar
function abrirModal(projeto) {
    projetoSelecionado.value = projeto;
    showModal.value = true;
}


// Envia requisição para excluir
const deleteProjeto = () => {
    if (!projetoToDelete.value) return;

    router.delete(`/projeto/deletar/${projetoToDelete.value.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
            projetoToDelete.value = null;
        },
    });
};
</script>

<template>
    <Layout>
        <ProjectViewModal :show="showModal" :projeto="projetoSelecionado" @close="showModal = false" />

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
                <option value="baixa" class="text-blue-500">Baixa</option>
                <option value="media" class="text-yellow-500">Média</option>
                <option value="alta" class="text-red-500">Alta</option>
            </select>

            <!-- Visibilidade -->
            <select v-model="visibilidade" class="select select-bordered outline-0 w-50">
                <option value="">Todas visibilidades</option>
                <option value="publico" class="">Público</option>
                <option value="privado">Privado</option>
            </select>

            <select v-model="autor" class="select select-bordered outline-0 w-50">
                <option value="">Todos os Projetos</option>
                <option value="meus">Meus Projetos</option>
            </select>

            <Link :href="route('projeto.create')"
                class="btn bg-primary/10 rounded-lg text-primary border-0 hover:bg-primary/20 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-circle-plus-icon lucide-circle-plus">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M8 12h8" />
                    <path d="M12 8v8" />
                </svg>Projeto
            </Link>
        </div>

        <!-- LISTA DE PROJETOS -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body">

                <!-- Se não existir projetos -->
                <p v-if="projetos.data.length === 0" class="text-center py-6 opacity-60 text-2xl">
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
                                    <button class="cursor-pointer" @click="abrirModal(projeto)">
                                        <span class="font-bold text-info">{{ projeto.nome }}</span>
                                    </button>

                                </td>

                                <td>
                                    <a v-if="projeto.github_link" :href="projeto.github_link"
                                        class="badge badge-link link-hover text-blue-600" target="_blank">
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
                                    <Link :href="route('usuario.perfil', { slug: projeto.user?.slug })" class="badge badge-ghost">
                                       {{ projeto.user?.name || '—' }}
                                    </Link>
                                </td>

                                <td>
                                    {{ projeto.data_fim ? new Date(projeto.data_fim).toLocaleDateString('pt-BR') : 'Sem data' }}
                                </td>

                                <td class="flex gap-2">

                                    <button @click="abrirModal(projeto)" class="btn text-success btn-sm btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-eye-icon lucide-eye">
                                            <path
                                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </button>

                                    <Link :href="route('tarefa.create', { projeto: projeto.slug })"
                                        class="btn btn-sm btn-primary btn-outline">
                                        Criar Tarefa
                                    </Link>


                                    <Link v-if="$page.props.auth.user.id == projeto.user?.id"
                                        :href="`/projeto/editar/${projeto.slug}`"
                                        class="btn btn-sm btn-info btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-pencil-icon lucide-pencil">
                                            <path
                                                d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                    </Link>

                                    <button v-if="$page.props.auth.user.id == projeto.user?.id"
                                        @click="confirmDelete(projeto)" class="btn btn-sm btn-error btn-outline">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash-icon lucide-trash">
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
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

        <!-- MODAL DE CONFIRMAÇÃO -->
        <dialog class="modal" :open="showDeleteModal">
            <div class="modal-box border border-base-300 shadow-xl">

                <h3 class="font-bold text-lg text-error flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-error" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2a10 10 0 100 20 10 10 0 000-20zM11 7h2v6h-2V7zm0 8h2v2h-2v-2z"
                            clip-rule="evenodd" />
                    </svg>
                    Confirmar exclusão
                </h3>

                <p class="py-4 text-base-content/80 mt-4 mb-0">
                    Tem certeza que deseja excluir o projeto
                    <strong class="text-primary font-bold">{{ projetoToDelete?.nome }}</strong> ?

                <p>Esta ação não pode ser desfeita.</p>
                </p>

                <div class="modal-action">
                    <button class="btn" @click="showDeleteModal = false">
                        Cancelar
                    </button>

                    <button class="btn btn-error" @click="deleteProjeto">
                        Confirmar
                    </button>
                </div>
            </div>
        </dialog>




    </Layout>
</template>

<style scoped>
.modal-box {
    margin-top: -500px !important;
}
</style>
