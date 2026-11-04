<script setup>
import Layout from '../../Layouts/Layout.vue';
import ProjectViewModal from "../../Modal/ProjectViewModal.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";
import { route } from 'ziggy-js';

const props = defineProps({
    projeto: Object,   // projeto atual
    usuarios: Array,   // usuários para atribuir à tarefa
});

const form = useForm({
    titulo: "",
    descricao: "",
    funcao: "",
    status: "pendente",
    prioridade: "media",
    data_fim: "",
    projeto_id: props.projeto.id,
    usuarios: [], // usuários atribuídos (IDs)
});



// modal projeto
const showModal = ref(false);
const projetoSelecionado = ref(null);

// Função que recebe o projeto ao clicar
function abrirModal(projeto) {
    projetoSelecionado.value = projeto;
    showModal.value = true;
}

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
                            <li>
                                <Link :href="route('projetos.index')">
                                    Lista de Projetos
                                </Link>
                            </li>

                            <li class="font-medium text-primary">
                                Criar Terefa
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="max-w-5xl mx-auto">

            <div v-if="$page.props.flash.error" role="alert" class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $page.props.flash.error }}</span>
            </div>


            <div class="card bg-base-100 shadow border border-base-300">
                <div class="card-body space-y-6">

                    <div role="alert" class="alert alert-vertical sm:alert-horizontal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-root-icon lucide-folder-root">
                            <path
                                d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                            <circle cx="12" cy="13" r="2" />
                            <path d="M12 15v5" />
                        </svg>
                        <span class="font-bold">{{ projeto.nome }}</span>
                        <div>
                            <button @click="abrirModal(projeto)" class="btn btn-sm btn-info">Ver</button>
                        </div>
                    </div>

                    <form @submit.prevent="form.post('/criar/tarefa', projeto.slug)" class="space-y-6">


                        <!-- Linha 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="label font-medium">Título</label>
                                <input v-model="form.titulo" type="text" class="input input-bordered w-full outline-0"
                                    placeholder="Título da tarefa" />
                                <p v-if="form.errors.titulo" class="text-error text-sm">
                                    {{ form.errors.titulo }}
                                </p>
                            </div>

                            <div>
                                <label class="label font-medium">Função</label>
                                <input v-model="form.funcao" type="text" class="input input-bordered w-full outline-0"
                                    placeholder="Ex: Backend, Frontend" />
                            </div>
                        </div>

                        <!-- Linha 2 -->
                        <div>
                            <label class="label font-medium">Descrição</label>
                            <textarea v-model="form.descricao" class="textarea textarea-bordered w-full outline-0"
                                rows="4" placeholder="Descrição detalhada da tarefa"></textarea>
                        </div>

                        <!-- Linha 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="label font-medium">Status</label>
                                <select v-model="form.status" class="select select-bordered w-full">
                                    <option value="pendente">Pendente</option>
                                    <option value="em_andamento">Em andamento</option>
                                   <!-- <option value="concluido">Concluído</option>-->
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>              

                            <div>
                                <label class="label font-medium">Prioridade</label>
                                <select v-model="form.prioridade" class="select select-bordered w-full">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>

                            <div>
                                <label class="label font-medium">Data final</label>
                                <input v-model="form.data_fim" type="date" class="input input-bordered w-full" />
                            </div>
                        </div>

                        <!-- Usuários -->
                        <div>
                            <label class="label font-medium">
                                Atribuir usuários à tarefa
                            </label>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <label v-for="user in usuarios" :key="user.id"
                                    class="flex items-center gap-3 border border-base-300 rounded-lg p-3 cursor-pointer hover:bg-base-200">
                                    <input type="checkbox" class="checkbox checkbox-primary" :value="user.id"
                                        v-model="form.usuarios" />
                                    <span class="font-medium">{{ user.name }}</span>
                                </label>
                            </div>

                            <p v-if="form.errors.usuarios" class="text-error text-sm mt-1">
                                {{ form.errors.usuarios }}
                            </p>
                        </div>

                        <!-- Ações -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-base-300">
                            <Link class="btn btn-ghost">
                                Cancelar
                            </Link>

                            <button type="submit" class="btn btn-primary px-8" :disabled="form.processing">
                                Criar Tarefa
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </Layout>
</template>
