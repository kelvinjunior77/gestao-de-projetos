<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from '../../Layouts/Layout.vue';

// Formulário Inertia
const form = useForm({
    name: '',
    description: '',
    github_link: '',
    priority: 'medium',      // low | medium | high | critical
    visibility: 'private',   // public | private | internal
    end_date: '',            // yyyy-mm-dd
});

// Prioridades / visibilidade (pode vir do server se preferir)
const priorities = [
    { value: 'low', label: 'Baixa' },
    { value: 'medium', label: 'Média' },
    { value: 'high', label: 'Alta' },
    { value: 'critical', label: 'Crítica' },
];

const statuses = [
    { value: 'not_started', label: 'Não Iniciado' },
    { value: 'in_progress', label: 'Em Progresso' },
    { value: 'completed', label: 'Concluído' },
    { value: 'on_hold', label: 'Em Espera' },
];

const visibilities = [
    { value: 'public', label: 'Público' },
    { value: 'private', label: 'Privado' },
    { value: 'internal', label: 'Interno' },
];

// submit
const submit = () => {
    form.post('/projetos', {
        onSuccess: () => {
            // opcional: limpar formulário ou redirecionar
            // form.reset();
        },
        onError: (errors) => {
            // os erros ficam em form.errors automaticamente
            console.log('Erros:', errors);
        }
    });
};

// reset
const reset = () => {
    form.reset('name', 'description', 'github_link', 'priority', 'visibility', 'end_date');
};
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
                                Criar Projeto
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <!-- Mensagem de sucesso flash (se enviada pelo backend) -->


        <div class="max-w-5xl mx-auto p-6">

            <div v-if="$page.props.flash.success" role="alert" class="alert alert-success mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $page.props.flash.success }}</span>
            </div>

        
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

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- GRID 2 COLUNAS -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nome -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nome do projeto</span></label>
                                <input v-model="form.name" type="text" placeholder="Ex: Plataforma X"
                                    class="input input-bordered w-full outline-0" />
                                <p v-if="form.errors.name" class="text-error text-sm mt-1">{{ form.errors.name }}</p>
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
                                <select v-model="form.priority" class="select select-bordered w-full outline-0">
                                    <option v-for="p in priorities" :key="p.value" :value="p.value">{{ p.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.priority" class="text-error text-sm mt-1">{{ form.errors.priority
                                    }}</p>
                            </div>

                            <!-- Visibilidade -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Visibilidade</span></label>
                                <select v-model="form.visibility" class="select select-bordered w-full outline-0">
                                    <option v-for="v in visibilities" :key="v.value" :value="v.value">{{ v.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.visibility" class="text-error text-sm mt-1">{{
                                    form.errors.visibility }}</p>
                            </div>

                            <!-- Status -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Status</span></label>
                                <select v-model="form.status" class="select select-bordered w-full outline-0">
                                    <option v-for="s in statuses" :key="s.value" :value="s.value">{{ s.label }}</option>
                                </select>
                                <p v-if="form.errors.status" class="text-error text-sm mt-1">{{ form.errors.status }}
                                </p>
                            </div>

                            <!-- Data final -->
                            <div class="form-control">
                                <label class="label"><span class="label-text">Data final (prazo)</span></label>
                                <input v-model="form.end_date" type="date" class="input input-bordered w-full outline-0" />
                                <p v-if="form.errors.end_date" class="text-error text-sm mt-1">{{ form.errors.end_date
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
                            <button type="submit" class="btn btn-primary w-full" :disabled="form.processing">
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
