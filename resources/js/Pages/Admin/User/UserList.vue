<script setup>
import Layout from "../../Layouts/Layout.vue";
import { ref, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";

// Props Inertia
const page = usePage();

const props = defineProps({
    users: Object,
    filters: Object,
});


// Estados dos filtros
const search = ref(page.props.filters?.search ?? "");
const cargo = ref(page.props.filters?.cargo ?? "");
const tipo = ref(page.props.filters?.tipo ?? "");

// Atualiza listagem sempre que filtro mudar
watch([search, cargo, tipo], () => {
    applyFilters();
});

// Função de filtros
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

// Paginação corrigida
function goTo(link) {
    if (!link.url) return;

    // extrai "page" da URL (...?page=3)
    const urlObj = new URL(link.url);
    const pageNumber = urlObj.searchParams.get("page");

    applyFilters(pageNumber);
}
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

                            <li class="font-medium text-primary">
                                Lista de usuarios
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
        <div class="p-6 max-w-7xl mx-auto">

          

            <!-- FILTROS -->
            <div class="flex gap-4 mb-6">

                <!-- Buscar -->
                <input v-model="search" type="text" placeholder="Pesquisar usuário..."
                    class="input input-bordered w-full outline-0" />

                <!-- Cargo -->
                <select v-model="cargo" class="select select-bordered w-48 outline-0">
                    <option value="">Cargo (todos)</option>
                    <option value="designer">Designer</option>
                    <option value="desenvolvedor">Desenvolvedor</option>
                    <option value="gestor">Gestor</option>
                    <option value="suporte">Suporte</option>
                </select>

                <!-- Tipo -->
                <select v-model="tipo" class="select select-bordered w-40 outline-0">
                    <option value="">Tipo (todos)</option>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>

            </div>




            <!-- LISTA -->
            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="text-sm text-base-content/70">
                                    <th>Usuário</th>
                                    <th>Cargo</th>
                                    <th>Tipo</th>
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

                                            <Link :href="`/admin/usuario/${user.slug}`" class="btn btn-sm btn-ghost">
                                            Ver
                                            </Link>

                                            <Link :href="`/admin/usuario/${user.slug}/editar`"
                                                class="btn btn-sm btn-info text-white">
                                            Editar
                                            </Link>
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
    </Layout>
</template>
