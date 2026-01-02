<script setup>
import Layout from '../../Layouts/Layout.vue'
import { usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { useForm, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const { props } = usePage()

const tarefa = props.tarefa
const usuarios = props.usuarios

// projeto vem DENTRO da tarefa
const projeto = computed(() => tarefa.projeto)

// form com dados preenchidos
const form = useForm({
    titulo: props.tarefa.titulo,
    descricao: props.tarefa.descricao,
    funcao: props.tarefa.funcao,
    status: props.tarefa.status,
    prioridade: props.tarefa.prioridade,
    data_fim: props.tarefa.data_fim,
    usuarios: props.tarefa.usuarios?.map(u => u.id) || [],
})

const submit = () => {
    form.put(route('tarefa.update', props.tarefa.id))
}
</script>

<template>
    <Layout>
        <div class="w-full px-6 py-6">

            <div class="max-w-10xl h-10 mb-10">
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

                                <li class="font-medium text-primary">
                                    Editar Tarefa
                                </li>
                            </ul>
                        </nav>
                    </div>


                </div>
            </div>

            <div v-if="$page.props.flash.error" role="alert" class="alert alert-error mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $page.props.flash.error }}</span>
            </div>

            <div class="mb-5 ">

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
            </div>

            <!-- Conteúdo principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- COLUNA ESQUERDA -->
                <div class="card bg-base-100 shadow-md border border-base-300">
                    <div class="card-body space-y-5">


                        <div>
                            <label class="label font-semibold">Título</label>
                            <input v-model="form.titulo" type="text"
                                class="input input-bordered w-full transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2" />
                            <p v-if="form.errors.titulo" class="text-error text-sm">
                                {{ form.errors.titulo }}
                            </p>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label class="label font-semibold">Descrição</label>
                            <textarea v-model="form.descricao" rows="4"
                                class="textarea textarea-bordered w-full transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2" />
                        </div>

                        <!-- Função -->
                        <div>
                            <label class="label font-semibold">Função</label>
                            <textarea v-model="form.funcao" rows="3" class="textarea textarea-bordered w-full 
                            transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2" />
                        </div>

                    </div>
                </div>

                <!-- COLUNA DIREITA -->
                <div class="card bg-base-100 shadow-md border border-base-300">
                    <div class="card-body space-y-5">

                        <!-- Grid status -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            <!-- Status -->
                            <div>
                                <label class="label font-semibold">Status</label>
                                <select v-model="form.status" class="select select-bordered w-full
                                transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2 ">
                                    <option value="pendente">Pendente</option>
                                    <option value="em_andamento">Em andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>

                            <!-- Prioridade -->
                            <div>
                                <label class="label font-semibold">Prioridade</label>
                                <select v-model="form.prioridade" class="select select-bordered w-full 
                                transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>

                            <!-- Data final -->
                            <div>
                                <label class="label font-semibold">Data final</label>
                                <input v-model="form.data_fim" type="date" class="input input-bordered w-full 
                                transition-all duration-100 outline-0 focus:border-blue-900 focus:border-2" />
                            </div>

                        </div>

                        <!-- Usuários -->
                        <div>
                            <label class="label font-semibold mb-2">
                                Usuários atribuídos
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <label v-for="user in usuarios" :key="user.id" class="flex items-center gap-3 p-3 
                                border border-base-300 rounded-xl cursor-pointer hover:bg-base-200 transition">
                                    <!-- Checkbox -->
                                    <input type="checkbox" class="checkbox checkbox-primary" :value="user.id"
                                        v-model="form.usuarios" />

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <div class="w-9 h-9 rounded-full ring ring-base-300">
                                            <img v-if="user.avatar" :src="`/storage/${user.avatar}`" :alt="user.name" />

                                            <div v-else
                                                class="flex items-center justify-center bg-primary text-primary-content font-bold">
                                                {{ user.name.charAt(0).toUpperCase() }}

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nome -->
                                    <span class="text-sm font-medium">
                                        {{ user.name }}
                                    </span>
                                </label>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <!-- AÇÕES -->
            <div class="flex justify-end gap-3 mt-6">
                <Link class="btn btn-ghost">
                    Cancelar
                </Link>

                <button @click="submit" :disabled="form.processing" class="btn btn-primary px-10">
                    Salvar alterações
                </button>
            </div>

        </div>
    </Layout>
</template>
