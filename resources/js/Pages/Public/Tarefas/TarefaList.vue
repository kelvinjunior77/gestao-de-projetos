<script setup>
import Layout from '../../Layouts/Layout.vue';
import TarefaModal from '../../../Components/Tarefa/TarefaModal.vue';
import { Link, router, usePage } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import { route } from 'ziggy-js';

const props = defineProps({
    tarefas: Object,
    filtros: {
        type: Object,
        default: () => ({}),
    },
});


const page = usePage()

// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');
const isNormal = computed(() => page.props.auth.user.tipo === 'normal')

// Filtros reativos
const search = ref(props.filtros.search || "");
const status = ref(props.filtros.status || "");
const prioridade = ref(props.filtros.prioridade || "");
const tipo = ref(props.filtros.tipo || "todas");


watch([search, status, prioridade, tipo], () => {
    applyFilters();
});

function applyFilters(page = 1) {
    router.get(
        route("tarefa.list"),
        {
            search: search.value,
            status: status.value,
            prioridade: prioridade.value,
            tipo: tipo.value,
            page,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
}

// modal
const showModal = ref(false)
const tarefaSelecionada = ref(null)

const abrirModal = (tarefa) => {
    tarefaSelecionada.value = tarefa
    showModal.value = true
}

// modal de delete 
const showDeleteModal = ref(false);
const tarefaDelete = ref(null);

// Abre o modal recebendo o usuário
const confirmDelete = (tarefa) => {
    tarefaDelete.value = tarefa;
    showDeleteModal.value = true;
};

// Envia requisição para excluir
const deleteTarefa = () => {
    if (!tarefaDelete.value) return;

    router.delete(`/tarefa/deletar/${tarefaDelete.value.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
            tarefaDelete.value = null;
        },
    });
};



// Paginação 
function goTo(link) {
    if (!link.url) return;

    // extrai "page" da URL (...?page=3)
    const urlObj = new URL(link.url);
    const pageNumber = urlObj.searchParams.get("page");

    applyFilters(pageNumber);
    //applyFiltersNormal(pageNumber);
}


</script>

<template>
    <TarefaModal :show="showModal" :tarefa="tarefaSelecionada" @close="showModal = false" />

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
                                Lista de Tarefas
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-6">

            <div v-if="$page.props.flash.success" role="alert" class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $page.props.flash.success }}</span>
            </div>


            <!-- Filtros -->
            <div class="flex gap-4 mb-6">


                <input v-model="search" type="text" placeholder="Buscar por título"
                    class="input input-bordered w-full outline-0" />

                <select v-model="status" class="select select-bordered w-50 outline-0">
                    <option value="">Status (todos)</option>
                    <option value="pendente" class="text-blue-500">Pendente</option>
                    <option value="em_andamento" class="text-yellow-500">Em andamento</option>
                    <option value="concluido" class="text-green-500">Concluído</option>
                    <option value="cancelado" class="text-red-500">Cancelado</option>
                </select>

                <select v-model="prioridade" class="select select-bordered  w-50 outline-0">
                    <option value="">Prioridade (todas)</option>
                    <option value="baixa" class="text-blue-500">Baixa</option>
                    <option value="media" class="text-yellow-500">Média</option>
                    <option value="alta" class="text-red-500">Alta</option>
                </select>


                <select v-model="tipo" class="select select-bordered outline-0 w-58">
                    <option value="todas">Todas tarefas</option>
                    <option value="minhas">Criadas por mim</option>
                    <option value="atribuidas">Atribuídas a mim</option>
                </select>


                <div class="w-50">
                    <Link :href="route('projetos.index')"
                        class="btn bg-primary/10 rounded-lg text-primary border-0 hover:bg-primary/20 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-plus-icon lucide-circle-plus">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 12h8" />
                            <path d="M12 8v8" />
                        </svg>Tarefa
                    </Link>
                </div>


            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto bg-base-100 border border-base-300 rounded-xl">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Projeto</th>
                            <th>Status</th>
                            <th>Prioridade</th>
                            <th>Responsáveis</th>
                            <th>Criador</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-if="tarefas.data.length === 0">
                            <td colspan="7" class="text-center py-6 opacity-60">
                                Nenhuma tarefa encontrada.
                            </td>
                        </tr>

                        <tr v-for="tarefa in tarefas.data" :key="tarefa.id">
                            <td class="font-medium">
                                <button  @click="abrirModal(tarefa)" class="font-bold text-info
                                 line-clamp-1 cursor-pointer" :title="tarefa.titulo">
                                    {{ tarefa.titulo }}
                                </button>

                            </td>

                            <td>
                                <span class="badge" :title="tarefa.projeto?.nome">
                                    {{ tarefa.projeto?.nome ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge" :class="{
                                    'badge badge-soft badge-warning': tarefa.status === 'pendente',
                                    'badge badge-soft badge-info': tarefa.status === 'em_andamento',
                                    'badge badge-soft badge-success': tarefa.status === 'concluido',
                                    'badge badge-soft badge-error': tarefa.status === 'cancelado',
                                }">
                                    {{ tarefa.status.replace('_', ' ') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge" :class="{
                                    'badge badge-soft badge-success': tarefa.prioridade === 'baixa',
                                    'badge badge-soft badge-warning': tarefa.prioridade === 'media',
                                    'badge badge-soft badge-error': tarefa.prioridade === 'alta',
                                }">
                                    {{ tarefa.prioridade }}
                                </span>
                            </td>

                            <td>
                                <div class="grid grid-cols-2 gap-1">
                                    <div v-for="user in tarefa.usuarios" :key="user.id" href="" class="text-sm">

                                        <Link :href="route('usuario.perfil', { slug: user.slug })" class="badge badge-soft badge-accent line-clamp-1" :title="user.name"
                                            v-if="$page.props.auth.user.id === user.id">
                                            {{ user.name }}
                                        </Link>

                                        <Link v-else :href="route('usuario.perfil', { slug: user.slug })" class="badge badge-soft badge-primary line-clamp-1"
                                            :title="user.name">
                                            {{ user.name }}
                                        </Link>

                                    </div>
                                </div>
                            </td>

                            <td>
                                <Link :href="route('usuario.perfil', { slug: tarefa.user?.slug })" class="badge badge-soft line-clamp-1" :title="tarefa.user?.name">
                                    {{ tarefa.user?.name ?? '-' }}
                                </Link>

                            </td>

                            <td class="flex justify-end gap-2">

                                <!---ver---->
                                <button @click="abrirModal(tarefa)" class="btn text-success btn-sm btn-outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>


                                <!---edit---->
                                <Link v-if="isAdmin || $page.props.auth.user.id === tarefa.user?.id"
                                    :href="route('tarefa.edit', tarefa.slug)" class="btn btn-sm btn-info btn-outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </Link>

                                <!---delete---->
                                <button v-if="isAdmin || $page.props.auth.user.id === tarefa.user?.id"
                                     @click="confirmDelete(tarefa)" class="btn btn-sm btn-error btn-outline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash">
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

            <!-- Paginação 
            <div v-if="tarefas.links.length > 3" class="flex justify-between items-center mt-6">
                <div class="join">
                    <Link v-for="link in tarefas.links" :key="link.label" :href="link.url ?? ''" class="join-item btn"
                        :class="{ 'btn-active': link.active }" v-html="link.label" preserve-scroll />
                </div>
            </div>-->

            <div class="flex justify-between items-center mt-6">

                <p class="text-sm opacity-70">
                    Página {{ tarefas.current_page }} de {{ tarefas.last_page }}
                </p>

                <div class="join">
                    <button v-for="(link, index) in tarefas.links" :key="index" class="btn join-item" :class="{
                        'btn-primary': link.active,
                        'btn-ghost': !link.active,
                        'pointer-events-none opacity-40': link.url === null
                    }" v-html="link.label" @click="goTo(link)"></button>
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
                    Tem certeza que deseja excluir tarefa
                    <strong class="text-primary font-bold">{{ tarefaDelete?.titulo }}</strong> ?

                <p>Esta ação não pode ser desfeita.</p>
                </p>

                <div class="modal-action">
                    <button class="btn" @click="showDeleteModal = false">
                        Cancelar
                    </button>

                    <button class="btn btn-error" @click="deleteTarefa">
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
