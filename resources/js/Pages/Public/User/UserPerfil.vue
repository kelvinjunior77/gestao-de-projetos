<script setup>
import Layout from "../../Layouts/Layout.vue";
import { defineProps, computed, ref} from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";

import { route } from "ziggy-js";

const page = usePage();

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
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

        <div class="mb-8">

            <p v-if="$page.props.auth.user.id == user.id" class="text-base-content/70">Informações completas do seu
                perfil.</p>
            <p v-else class="text-base-content/70">Informações completas do usuário.</p>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">

                <!-- SEÇÃO DE TOPO -->
                <div class="flex items-center gap-6">

                    <!-- FOTO DE PERFIL -->
                    <div class="avatar">
                        <div class="w-32 h-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img :src="user.avatar ? `/storage/${user.avatar}` : 'https://placehold.co/100x100?text=Avatar'"
                                alt="Avatar do Usuário" class="object-cover" />
                        </div>
                    </div>

                    <!-- INFORMAÇÕES PRINCIPAIS -->
                    <div>
                        <h2 class="text-2xl font-semibold text-base-content">
                            {{ user.name }}
                        </h2>
                        <p class="text-base-content/70 text-sm">
                            {{ user.email }}
                        </p>

                        <div class="mt-3 flex gap-3">
                            <div class="badge badge-primary badge-lg">{{ user.cargo }}</div>
                            <div class="badge badge-secondary badge-lg capitalize">
                                {{ user.tipo }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider my-6"></div>

                <!-- DADOS COMPLETOS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

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

                </div>

            </div>
        </div>

        <div class="flex items-center mb-6 mt-4 gap-2">

            <Link v-if="$page.props.auth.user.id == user.id" v-show="!isAdmin"
                :href="route('usuario.edit', user.slug)" class="btn btn-success  w-2xs ">Editar</Link>

            <Link v-if="isAdmin" :href="route('admin.edit.usuario', user.slug)" class="btn btn-success  w-2xs ">Editar
            </Link>

          
            <button v-if="isAdmin" class="btn btn-error w-2xs text-white" @click="confirmDelete(user)">
                Excluir
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
