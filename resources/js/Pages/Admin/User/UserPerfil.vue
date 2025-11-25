<script setup>
import Layout from "../../Layouts/Layout.vue";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

// Avatar seguro do storage
const avatarUrl = props.user.avatar
    ? `/storage/avatars/${props.user.avatar}`
    : "https://placehold.co/200x200?text=Avatar";
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
                                <Link href="/admin/dashboard">
                                Home
                                </Link>
                            </li>

                            <li>
                                <Link href="/admin/listar/usuarios">
                                Lista de usuarios
                                </Link>
                            </li>

                            <li class="font-medium text-primary">
                                Perfil de usuario
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="mb-8">
            <p class="text-base-content/70">Informações completas do usuário.</p>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">

                <!-- SEÇÃO DE TOPO -->
                <div class="flex items-center gap-6">

                    <!-- FOTO DE PERFIL -->
                    <div class="avatar">
                        <div class="w-32 h-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img :src="user.avatar ? `/storage/${user.avatar}` : 'https://placehold.co/100x100?text=Avatar'" alt="Avatar do Usuário" class="object-cover" />
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
                 <a href="" class="btn btn-success  w-2xs ">Editar</a>  <a href="" class="btn btn-error w-2xs text-white">Excluir</a>
         </div>

    </Layout>
</template>
