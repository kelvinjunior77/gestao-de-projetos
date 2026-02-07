<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from '../Layouts/Layout.vue';

const props = defineProps({
    recentTasks: {
        type: Array,
        default: () => ([
            { id: 1, name: 'Isabella Christensen', desc: 'Design da Home', date: '11 MAI 12:56', avatar: 'https://i.pravatar.cc/150?u=1', status: 'pending' },
            { id: 2, name: 'Mathilde Andersen', desc: 'Correção de Bugs API', date: '11 MAI 10:35', avatar: 'https://i.pravatar.cc/150?u=2', status: 'rejected' },
            { id: 3, name: 'Karla Sorenson', desc: 'Deploy Produção', date: '10 MAI 09:00', avatar: 'https://i.pravatar.cc/150?u=3', status: 'approved' },
        ])
    },

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
                        <progress class="progress progress-warning w-full" value="40" max="100"></progress>
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
                            <p class="text-3xl font-bold mt-2">12</p>
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
                        <progress class="progress progress-error w-full" value="20" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <div class="col-span-1 xl:col-span-2 card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-0">
                    <div class="p-5 border-b border-base-200">
                        <h3 class="font-bold text-lg">Tarefas Recentes</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Atividade</th>
                                    <th>Data</th>
                                    <th class="text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="task in recentTasks" :key="task.id" class="hover">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-10 h-10">
                                                    
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">{{ task.name }}</div>
                                                <div class="text-xs opacity-50">Dev Team</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ task.desc }}
                                        <br />
                                        <span class="badge badge-ghost badge-sm">Web Design</span>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2 text-xs text-base-content/70">
                                            <span class="w-2 h-2 rounded-full bg-success"></span>
                                            {{ task.date }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-xs btn-error btn-outline mr-2">Rejeitar</button>
                                        <button class="btn btn-xs btn-success text-white">Aprovar</button>
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