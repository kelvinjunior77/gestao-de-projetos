<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from '../Layouts/Layout.vue';
import TarefaModal from '../../Components/Tarefa/TarefaModal.vue';
import { ref } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps({

    projetos: {
        type: Number,
        required: true,
    },
    tarefas: {
        type: Number,
        required: true,
    },
    projetosFinalizados: {
        type: Number,
        required: false,
    },
    tarefasFeitas: {
        type: Number,
        required: false,
    },

    tarefasRecentes: {
        type: Array,
        required: true,
    },

    notificacoes: {
        type: Array,
        required: true,
    },
    usuarios: {
        type: Number,
        required: true,
    },
    cargos: {
        type: Number,
        required: true,
    }

});

</script>

<template>

    <Head title="Dashboard" />


    <Layout>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-6">

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Projetos</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.projetos }}</p>
                        </div>
                        <div class="p-3 bg-primary/10 rounded-full text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                                <circle cx="13" cy="12" r="2" />
                                <path d="M18 19c-2.8 0-5-2.2-5-5v8" />
                                <circle cx="20" cy="19" r="2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-primary w-full" value="100" max="100"></progress>
                        <p class="text-xs text-base-content/50 mt-1">70% da meta atingida</p>
                    </div>



                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Projetos Finalizados</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.projetosFinalizados }}</p>
                        </div>
                        <div class="p-3 bg-success/10 rounded-full text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                                <path d="m9 13 2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-success w-full" value="100" max="100"></progress>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Tarefas</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.tarefas }}</p>
                        </div>
                        <div class="p-3 bg-warning/10 rounded-full text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                <path d="M12 11h4" />
                                <path d="M12 16h4" />
                                <path d="M8 11h.01" />
                                <path d="M8 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-warning w-full" value="100" max="100"></progress>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Tarefas Feitas</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.tarefasFeitas }}</p>
                        </div>
                        <div class="p-3 bg-info/10 rounded-full text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                <path d="m9 14 2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-info w-full" value="100" max="100"></progress>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Devs Ativos</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.usuarios }}</p>
                        </div>
                        <div class="p-3 bg-error/10 rounded-full text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 21a8 8 0 0 0-16 0" />
                                <circle cx="10" cy="8" r="5" />
                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-error w-full" value="100" max="100"></progress>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Habilidades -
                                Compentencias</h2>
                            <p class="text-3xl font-bold mt-2">{{ props.cargos }}</p>
                        </div>
                        <div class="p-3 bg-error/10 rounded-full text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-monitor-cog-icon lucide-monitor-cog">
                                <path d="M12 17v4" />
                                <path d="m14.305 7.53.923-.382" />
                                <path d="m15.228 4.852-.923-.383" />
                                <path d="m16.852 3.228-.383-.924" />
                                <path d="m16.852 8.772-.383.923" />
                                <path d="m19.148 3.228.383-.924" />
                                <path d="m19.53 9.696-.382-.924" />
                                <path d="m20.772 4.852.924-.383" />
                                <path d="m20.772 7.148.924.383" />
                                <path d="M22 13v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7" />
                                <path d="M8 21h8" />
                                <circle cx="18" cy="6" r="3" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-error w-full" value="100" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="col-span-1 xl:col-span-2 card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-0">
                    <div class="p-2 border-b border-base-200">
                        <h3 class="font-bold text-lg text-amber-400">Tarefas Recentes</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Criador</th>
                                    <th>Funcão</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tarefa in tarefasRecentes" :key="tarefa.id" class="hover">
                                    <td>
                                        <span class="font-bold text-primary">{{ tarefa.titulo }}</span>
                                    </td>
                                    <td>

                                        <span class="">{{ tarefa.user?.name }}</span>
                                    </td>
                                    <td :title="tarefa.funcao" class="max-w-sm truncate">
                                        {{ tarefa.funcao }}
                                    </td>
                                    <td>
                                        <span :class="{
                                            'badge badge-soft badge-success': tarefa.status === 'concluido',
                                            'badge badge-soft badge-warning': tarefa.status === 'pendente',
                                            'badge badge-soft badge-error': tarefa.status === 'cancelado',
                                            'badge badge-soft badge-info': tarefa.status === 'em_andamento',
                                        }">
                                            {{ tarefa.status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2 text-xs text-base-content/70">
                                            <span class="w-2 h-2 rounded-full bg-success"></span>
                                            {{ tarefa.created_at
                                                ? new Date(tarefa.created_at).toLocaleString('pt-BR', {
                                                    day: '2-digit',
                                                    month: '2-digit',
                                                    year: 'numeric',
                                                    hour: '2-digit',
                                                    minute: '2-digit'
                                                })
                                                : 'Sem data'
                                            }}

                                        </div>
                                    </td>
                                    <td class="text-right">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </Layout>
</template>