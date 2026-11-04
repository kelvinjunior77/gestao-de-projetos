<script setup>
import Layout from "../../Layouts/Layout.vue";
import { ref, watch, computed } from "vue";
import { route } from "ziggy-js";
import { Link, router, usePage } from "@inertiajs/vue3";

const page = usePage();

const props = defineProps({
    cargos: Object,
    filters: Object,
    cargo_total: Number,
});


// Estados dos filtros
const search = ref(page.props.filters?.search ?? "");

// Atualiza listagem sempre que filtro mudar
watch([search], () => {
    applyFilters();
});

// Função de filtros admin
function applyFilters(page = 1) {
    router.get(
        "/admin/lista/cargos",
        {
            search: search.value,
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
}

// modal
const showDeleteModal = ref(false);
const cargoToDelete = ref(null);

// Abre o modal recebendo o usuário
const confirmDelete = (cargo) => {
    cargoToDelete.value = cargo;
    showDeleteModal.value = true;
};

// Envia requisição para excluir
const deleteCargo = () => {
    if (!cargoToDelete.value) return;

    router.delete(`/admin/deletar/cargo/${cargoToDelete.value.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
            cargoToDelete.value = null;
        },
    });
};
// --->
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
                                Lista de cargo
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
        <div class="p-6 max-w-7xl mx-auto">

            <!-- FILTROS  admin-->

            <div class="flex gap-4 mb-6">

                <!-- Buscar -->
                <input v-model="search" type="text" placeholder="Pesquisar cargo..."
                    class="input input-bordered w-full outline-0" />

                <div class="w-40">
                    <Link :href="route('admin.cad.cargo')"
                        class="btn bg-primary/10 rounded-lg text-primary border-0 hover:bg-primary/20 gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-plus-icon lucide-circle-plus">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 12h8" />
                            <path d="M12 8v8" />
                        </svg>adicionar
                    </Link>
                </div>

                <div class="w-40">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                            <line x1="9" x2="9" y1="3" y2="21" />
                        </svg>competências <div class="badge badge-sm badge-secondary">{{ cargo_total }}</div>
                    </button>
                </div>

            </div>


            <div role="alert" class="alert alert-success mb-4 mt-0" v-if="$page.props.flash.success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $page.props.flash.success }}</span>
            </div>

            <!-- LISTA -->
            <div class="card bg-base-100 shadow-sm border border-base-200">


                <div class="card-body">

                    <!-- Se não existir cargos -->
                    <p v-if="cargos.data.length === 0" class="text-center py-6 opacity-60 text-2xl">
                        Nenhuma competência encontrada.
                    </p>

                    <div v-else class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="text-sm text-base-content/70">
                                    <th>Nome</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="cargo in cargos.data" :key="cargo.id">

                                    <td>
                                        <div class="flex items-center gap-3">

                                            <div>
                                                <p class="font-semibold text-base-content">{{ cargo.nome }}</p>
                                                <p class="text-sm text-base-content/60">
                                                    {{ cargo.descricao }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">


                                            <Link :href="route('admin.edit.cargo', cargo.id)"
                                                class="btn btn-sm btn-info btn-outline gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-pencil-icon lucide-pencil">
                                                    <path
                                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                    <path d="m15 5 4 4" />
                                                </svg>
                                            </Link>


                                            <button class="btn btn-sm btn-error btn-outline gap-2"
                                                @click="confirmDelete(cargo)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-trash-icon lucide-trash">
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                            </button>


                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINAÇÃO -->
                    <div class="flex justify-between items-center mt-6">

                        <p class="text-sm opacity-70">
                            Página {{ cargos.current_page }} de {{ cargos.last_page }}
                        </p>

                        <div class="join">
                            <button v-for="(link, index) in cargos.links" :key="index" class="btn join-item" :class="{
                                'btn-primary': link.active,
                                'btn-ghost': !link.active,
                                'pointer-events-none opacity-40': link.url === null
                            }" v-html="link.label" @click="goTo(link)"></button>
                        </div>

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
                    Tem certeza que deseja excluir a competência
                    <strong class="text-primary font-bold">{{ cargoToDelete?.nome }}</strong> ?

                <p>Esta ação não pode ser desfeita.</p>
                </p>


                <div class="modal-action">
                    <button class="btn" @click="showDeleteModal = false">
                        Cancelar
                    </button>

                    <button class="btn btn-error" @click="deleteCargo">
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
