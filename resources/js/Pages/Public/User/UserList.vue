<script setup>
import Layout from "../../Layouts/Layout.vue";
import { ref, watch, computed } from "vue";
import { route } from 'ziggy-js';
import { Link, router, usePage } from "@inertiajs/vue3";

const page = usePage();

const props = defineProps({
    users: Object,
    filters: Object,
    id: Array,
    cargos: {
        type: Object,
        required: true,
    },

    totalUsuarios: {
        type: Number,
        required: true,
    },

    contarUsuario: {
        type: Number,
        required: true,
    }
});


// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');
const isNormal = computed(() => page.props.auth.user.tipo === 'normal')


// Estados dos filtros
const search = ref(page.props.filters?.search ?? "");
const cargo = ref(page.props.filters?.cargo ?? "");
const tipo = ref(page.props.filters?.tipo ?? "");


// Atualiza listagem sempre que filtro mudar
watch([search, cargo, tipo], () => {
    applyFilters();
    applyFiltersNormal();
});

// Função de filtros admin
function applyFilters(page = 1) {
    router.get(
        "/admin/listar/usuarios",
        {
            search: search.value,
            cargo: cargo.value,
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


// Função de filtros
function applyFiltersNormal(page = 1) {
    router.get(
        "/lista/usuarios",
        {
            search: search.value,
            cargo: cargo.value,
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

// Paginação corrigida
function goTo(link) {
    if (!link.url) return;

    // extrai "page" da URL (...?page=3)
    const urlObj = new URL(link.url);
    const pageNumber = urlObj.searchParams.get("page");

    applyFilters(pageNumber);
    applyFiltersNormal(pageNumber);
}

// modal
const showDeleteModal = ref(false);
const userToDelete = ref(null);

// Abre o modal recebendo o usuário
const confirmDelete = (user) => {
    userToDelete.value = user;
    showDeleteModal.value = true;
};

// Envia requisição para excluir
const deleteUser = () => {
    if (!userToDelete.value) return;

    router.delete(`/admin/deletar/usuario/${userToDelete.value.id}`, {
        onSuccess: () => {
            showDeleteModal.value = false;
            userToDelete.value = null;
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
                                Lista de usuarios
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
        <div class="p-6 max-w-7xl mx-auto">

            <!-- FILTROS  admin-->

            <div class="flex gap-4 mb-6" v-if="isAdmin">

                <!-- Buscar -->
                <input v-model="search" type="text" placeholder="Pesquisar usuário..."
                    class="input input-bordered w-full outline-0" />

                <!-- Cargo -->
                <select v-model="cargo" class="select select-bordered w-48 outline-0">
                    <option value="">Competências (todos)</option>
                    <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.nome">
                        {{ cargo.nome }}
                    </option>
                </select>

                <!-- Tipo -->
                <select v-model="tipo" class="select select-bordered w-40 outline-0">
                    <option value="">Tipo (todos)</option>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>

                <div class="w-40">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-icon lucide-users">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>Usuarios <div class="badge badge-sm badge-secondary">{{ contarUsuario }} {{ totalUsuarios
                            }}</div>
                    </button>
                </div>

            </div>

            <!-- FILTROS  usuario normal-->
            <div class="flex gap-4 mb-6" v-if="isNormal">

                <!-- Buscar -->
                <input v-model="search" type="text" placeholder="Pesquisar usuário..."
                    class="input input-bordered w-full outline-0" />

                <!-- Cargo -->
                <select v-model="cargo" class="select select-bordered w-48 outline-0">
                    <option value="">Competências(todos)</option>
                    <option v-for="cargo in cargos" :key="cargo.id" :value="cargo.nome">
                        {{ cargo.nome }}
                    </option>
                </select>

                <!-- Tipo -->
                <select v-model="tipo" class="select select-bordered w-40 outline-0">
                    <option value="">Tipo (todos)</option>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>

                <div class="w-40">
                    <button class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users-icon lucide-users">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>Usuarios <div class="badge badge-sm badge-secondary">{{ totalUsuarios }}</div>
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

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="text-sm text-base-content/70">
                                    <th>Usuário</th>
                                    <th>Competências - Cargo</th>
                                    <th></th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">

                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="w-12 h-12 rounded-full">
                                                    <img
                                                        :src="user.avatar ? `/storage/${user.avatar}` : 'https://placehold.co/100x100?text=Avatar'" />
                                                </div>
                                            </div>

                                            <div>
                                                <p class="font-semibold">{{ user.name }}</p>
                                                <p class="text-sm text-base-content/60">
                                                    {{ user.email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ user.cargo || "-" }}</td>

                                    <td>
                                        <span class="badge" :class="user.tipo === 'admin'
                                            ? 'badge-primary'
                                            : 'badge-neutral'">
                                            {{ user.tipo }}
                                        </span>
                                    </td>

                                    <td class="text-right">
                                        <div class="flex justify-end gap-2">

                                            <Link v-if="isAdmin" :href="`/admin/perfil/usuario/${user.slug}`"
                                                class="btn btn-sm btn-ghost">
                                            Ver
                                            </Link>

                                            <Link v-if="isNormal" :href="`/usuario/perfil/${user.slug}`"
                                                class="btn btn-sm btn-ghost">
                                            Ver
                                            </Link>

                                            <!---
                                            <Link :href="`/admin/editar/usuario/${user.slug}`"
                                                class="btn btn-sm btn-info text-white">
                                            Editar
                                            </Link>--->

                                            <Link v-if="isAdmin" :href="route('admin.edit.usuario', user.slug)"
                                                class="btn btn-sm btn-info text-white">
                                            Editar
                                            </Link>

                                            <Link v-if="isNormal && $page.props.auth.user.id === user.id"
                                                :href="route('usuario.edit', user.slug)"
                                                class="btn btn-sm btn-info text-white">
                                            Editar
                                            </Link>

                                            <!-----
                                            <button v-if="id !== user.id" href="" @click="confirmDelete(user)"
                                                class="btn btn-sm btn-error">
                                                Excluir
                                            </button> -->

                                            <button class="btn btn-error btn-sm" @click="confirmDelete(user)"
                                                v-if="id !== user.id && isAdmin">
                                                Excluir
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
                            Página {{ users.current_page }} de {{ users.last_page }}
                        </p>

                        <div class="join">
                            <button v-for="(link, index) in users.links" :key="index" class="btn join-item" :class="{
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
                    Tem certeza que deseja excluir o usuário
                    <strong class="text-primary font-bold">{{ userToDelete?.name }}</strong> ?

                <p>Esta ação não pode ser desfeita.</p>
                </p>


                <div class="modal-action">
                    <button class="btn" @click="showDeleteModal = false">
                        Cancelar
                    </button>

                    <button class="btn btn-error" @click="deleteUser">
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
