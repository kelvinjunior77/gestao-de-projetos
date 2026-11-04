<script setup>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Layout from '../../Layouts/Layout.vue';

// Formulário Inertia
const form = useForm({
    nome: '',
    descricao: '',
    github_link: '',
    prioridade: 'média',      // baixa | media | alta | critica
    visibilidade: 'privado',   // publico | privado | interno
    status: 'pendente',        // planejado | em_andamento | concluido | 
    data_fim: '',            // yyyy-mm-dd
});

// Prioridades / visibilidade (pode vir do server se preferir)
const prioridades = [
    { value: 'baixa', label: 'Baixa', class: 'text-blue-500' },
    { value: 'média', label: 'Média', class: 'text-yellow-600'},
    { value: 'alta', label: 'Alta', class: 'text-red-600'},
    //{ value: 'critica', label: 'Crítica' },
];

const visibilidades = [
    { value: 'publico', label: 'Público', class: 'text-green-600' },
    { value: 'privado', label: 'Privado', class: 'text-gray-600' },
    //{ value: 'interno', label: 'Interno' },
];


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
                                Criar Projeto
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
        
        <!-- Mensagem de sucesso flash (se enviada pelo backend) -->


        <div class="max-w-5xl mx-auto p-6">


            <div  v-if="$page.props.flash.error" role="alert" class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
               <span>{{ $page.props.flash.error }}</span>
            </div>

            <div class="card bg-base-100 shadow-md border border-base-200">

                <div class="card-body p-6">

                    <form @submit.prevent="form.post('/projeto/criar')" class="space-y-6">
                        <!-- GRID 2 COLUNAS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nome -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nome do projeto</span></label>
                                <input v-model="form.nome" type="text" placeholder="Ex: Plataforma X"
                                    class="input input-bordered w-full outline-0" />
                                <p v-if="form.errors.nome" class="text-error text-sm mt-1">{{ form.errors.nome }}</p>
                            </div>

                            <!-- Link GitHub -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Link do GitHub</span></label>
                                <input v-model="form.github_link" type="url"
                                    placeholder="https://github.com/usuario/repositorio"
                                    class="input input-bordered w-full outline-0" />
                                <p v-if="form.errors.github_link" class="text-error text-sm mt-1">{{
                                    form.errors.github_link }}</p>
                            </div>

                            <!-- Prioridade -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Prioridade</span></label>
                                <select v-model="form.prioridade" class="select select-bordered w-full outline-0">
                                    <option v-for="p in prioridades" :key="p.value" :value="p.value" :class="p.class">
                                        {{ p.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.prioridade" class="text-error text-sm mt-1">{{ form.errors.prioridade
                                    }}</p>
                            </div>

                            <!-- Visibilidade -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Visibilidade</span></label>
                                <select v-model="form.visibilidade" class="select select-bordered w-full outline-0">
                                    <option v-for="v in visibilidades" :key="v.value" :value="v.value" :class="v.class">
                                        {{ v.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.visibilidade" class="text-error text-sm mt-1">{{
                                    form.errors.visibilidade }}</p>
                            </div>

                            <!-- Status -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Status</span></label>

                                <select v-model="form.status" class="select select-bordered w-full outline-0">

                                    <option value="pendente" class="text-blue-500">Pendente</option>

                                    <option value="em_andamento" class="text-yellow-500">Em andamento</option>
                                    <option value="concluido" class="text-green-500">Concluído</option>

                                </select>
                                <p v-if="form.errors.status" class="text-error text-sm mt-1">{{ form.errors.status }}
                                </p>
                            </div>

                            <!-- Data final -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Data final (prazo)</span></label>
                                <input v-model="form.data_fim" type="date" class="input input-bordered w-full outline-0" />
                                <p v-if="form.errors.data_fim" class="text-error text-sm mt-1">{{ form.errors.data_fim
                                    }}</p>
                            </div>

                            <!-- Campo vazio para balanço do grid (se quiser algo aqui, remover div) -->
                            <div></div>
                        </div>

                        <!-- Descrição em largura total -->
                        <div class="form-control">
                            <label class="label"><span class="label-text">Descrição</span></label>
                            <textarea v-model="form.description" class="textarea textarea-bordered w-full outline-0" rows="5"
                                placeholder="Descreva o projeto, objetivos e escopo..."></textarea>
                            <p v-if="form.errors.description" class="text-error text-sm mt-1">{{ form.errors.description
                                }}</p>
                        </div>

                        <!-- Ações -->
                        <div class="flex gap-2 items-center">
                            <button type="submit" class="btn btn-soft btn-primary w-full" :disabled="form.processing">
                                <span v-if="!form.processing">Salvar Projeto</span>
                                <span v-else class="loading loading-spinner"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* pequenas customizações podem ir aqui */
</style>
