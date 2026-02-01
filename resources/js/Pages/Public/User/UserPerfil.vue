<script setup>
import Layout from "../../Layouts/Layout.vue";
import { defineProps, computed, ref } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";

import { route } from "ziggy-js";

const page = usePage();

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },

    projetosCriados: Number,
    tarefasCriadas: Number,
    tarefasSelecionadas: Number,
});


// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');
const isNormal = computed(() => page.props.auth.user.tipo === 'normal')

// Avatar seguro do storage
const avatarUrl = props.user.avatar
    ? `/storage/avatars/${props.user.avatar}`
    : "https://placehold.co/200x200?text=Avatar";

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

                            <li>
                                <Link :href="route('usuario.lista')">
                                    Lista de usuarios
                                </Link>
                            </li>

                            <li v-if="$page.props.auth.user.id == user.id" class="font-medium text-primary">
                                Meu perfil
                            </li>

                            <li v-else class="font-medium text-primary">
                                Perfil usuario
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="mb-4">

            <p v-if="$page.props.auth.user.id == user.id" class="text-base-content/70 flex items-center gap-2">
                <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt">
                        <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-linecap="square"
                            stroke-miterlimit="10" stroke-width="2"></circle>
                        <path d="m12,17v-5.5c0-.276-.224-.5-.5-.5h-1.5" fill="none" stroke="currentColor"
                            stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path>
                        <circle cx="12" cy="7.25" r="1.25" fill="currentColor" stroke-width="2"></circle>
                    </g>
                </svg> Informações completas do seu perfil.
            </p>
            <p v-else class="text-base-content/70 flex items-center gap-2">
                <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt">
                        <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-linecap="square"
                            stroke-miterlimit="10" stroke-width="2"></circle>
                        <path d="m12,17v-5.5c0-.276-.224-.5-.5-.5h-1.5" fill="none" stroke="currentColor"
                            stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></path>
                        <circle cx="12" cy="7.25" r="1.25" fill="currentColor" stroke-width="2"></circle>
                    </g>
                </svg>
                Informações completas do usuário.
            </p>
        </div>


        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">


                <div class="flex items-center gap-6">


                    <div class="avatar">
                        <div class="w-32 h-32 rounded-full">
                            <img :src="user.avatar ? `/storage/${user.avatar}` : 'https://placehold.co/100x100?text=Avatar'"
                                alt="Avatar do Usuário" class="object-cover" />
                        </div>
                    </div>


                    <div>
                        <h2 class="text-2xl font-semibold text-primary">
                            {{ user.name }}
                        </h2>
                        <p class="text-base-content/70 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail
                                mr-0.9">
                                <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                <rect x="2" y="4" width="20" height="16" rx="2" />
                            </svg>
                            {{ user.email }}
                        </p>

                        <div class="mt-3 flex gap-3">
                            <div class="badge badge-soft badge-primary badge-lg text-sm">{{ user.cargo }}</div>
                            <div class="badge badge-soft badge-secondary badge-lg capitalize text-sm">
                                {{ user.tipo }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col ml-auto text-right gap-1 bg-base-200 p-4 rounded-lg">
                        <div
                            class="stat bg-base-100 p-3 flex rounded-lg shadow-sm border border-base-300 hover:shadow-md h-10">
                            <div class="stat-title text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-folder-git2-icon lucide-folder-git-2 
                                    mr-1">
                                    <path d="M18 19a5 5 0 0 1-5-5v8" />
                                    <path
                                        d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                                    <circle cx="13" cy="12" r="2" />
                                    <circle cx="20" cy="19" r="2" />
                                </svg>Projetos Criados:
                            </div>
                            <div class="stat-value text-primary text-xl flex items-center">{{ projetosCriados }}</div>
                        </div>

                       

                        <div
                            class="stat bg-base-100 p-3 flex rounded-lg shadow-sm border border-base-300 hover:shadow-md h-10">
                            <div class="stat-title text-sm gap-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-clipboard-list-icon lucide-clipboard-list
                                    mr-0">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path
                                        d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <path d="M12 11h4" />
                                    <path d="M12 16h4" />
                                    <path d="M8 11h.01" />
                                    <path d="M8 16h.01" />
                                </svg> Tarefas Criado:
                            </div>
                            <span class="stat-value text-primary text-xl flex items-center">{{ tarefasCriadas }}</span>
                        </div>


                        <div class="stat bg-base-100 p-3 rounded-lg shadow-sm border border-base-300 h-10 flex items-center hover:shadow-md">
                            <div class="stat-title text-sm">Tarefas Selecionadas: </div>
                            <div class="stat-value text-primary text-xl">{{ tarefasSelecionadas }}</div>
                        </div>
                    </div>


                </div>

                <div class="divider my-6"></div>

                <!-- DADOS COMPLETOS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Nome Completo</span>
                        <span class="text-base-content/70">{{ user.name }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Email</span>
                        <span class="text-base-content/70">{{ user.email }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Cargo</span>
                        <span class="text-base-content/70 capitalize ">{{ user.cargo }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Tipo de Conta</span>
                        <span class="text-base-content/70 capitalize">{{ user.tipo }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Slug</span>
                        <span class="text-base-content/70">{{ user.slug }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Criado em</span>
                        <span class="text-base-content/70">{{ new Date(user.created_at).toLocaleString() }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">Última atualização</span>
                        <span class="text-base-content/70">{{ new Date(user.updated_at).toLocaleString() }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="font-semibold">ID do Usuário</span>
                        <span class="text-base-content/70">{{ user.id }}</span>

                    </div>
                </div>

            </div>
        </div>

        <div class="flex items-center mb-6 mt-4 gap-2">

            <Link v-if="isNormal && $page.props.auth.user.id === user.id" :href="route('usuario.edit', user.slug)"
                class="btn btn-outline btn-success  w-2xs ">Editar</Link>

            <Link v-if="isAdmin" :href="route('admin.edit.usuario', user.slug)"
                class="btn btn-outline btn-success  w-2xs ">
                Editar
            </Link>

            <button v-if="isNormal && $page.props.auth.user.id === user.id" class="btn btn-outline btn-error w-2xs"
                @click="confirmDelete(user)">
                Excluir sua conta
            </button>

            <button v-if="isAdmin" class="btn btn-outline btn-error w-2xs " @click="confirmDelete(user)">
                Excluir conta
            </button>


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
                    Tem certeza que deseja excluir conta
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
