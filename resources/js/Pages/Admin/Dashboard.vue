<script setup>
import { Head, Link } from '@inertiajs/vue3';

import Layout from '../Layouts/Layout.vue';


// Props que virão do seu Controller Laravel (Exemplo)
const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            projects: 10,
            projectsFinished: 10,
            tasks: 36,
            tasksFinished: 80,
            developers: 22
        })
    },
    recentTasks: {
        type: Array,
        default: () => ([
            { id: 1, name: 'Isabella Christensen', desc: 'Design da Home', date: '11 MAI 12:56', avatar: 'https://i.pravatar.cc/150?u=1', status: 'pending' },
            { id: 2, name: 'Mathilde Andersen', desc: 'Correção de Bugs API', date: '11 MAI 10:35', avatar: 'https://i.pravatar.cc/150?u=2', status: 'rejected' },
            { id: 3, name: 'Karla Sorenson', desc: 'Deploy Produção', date: '10 MAI 09:00', avatar: 'https://i.pravatar.cc/150?u=3', status: 'approved' },
        ])
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
                            <p class="text-3xl font-bold mt-2">{{ stats.projects }}</p>
                        </div>
                        <div class="p-3 bg-primary/10 rounded-full text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5"/><circle cx="13" cy="12" r="2"/><path d="M18 19c-2.8 0-5-2.2-5-5v8"/><circle cx="20" cy="19" r="2"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-primary w-full" value="70" max="100"></progress>
                        <p class="text-xs text-base-content/50 mt-1">70% da meta atingida</p>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Finalizados</h2>
                            <p class="text-3xl font-bold mt-2">{{ stats.projectsFinished }}</p>
                        </div>
                        <div class="p-3 bg-success/10 rounded-full text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/><path d="m9 13 2 2 4-4"/></svg>
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
                            <p class="text-3xl font-bold mt-2">{{ stats.tasks }}</p>
                        </div>
                        <div class="p-3 bg-warning/10 rounded-full text-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
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
                            <p class="text-3xl font-bold mt-2">{{ stats.tasksFinished }}</p>
                        </div>
                        <div class="p-3 bg-info/10 rounded-full text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <progress class="progress progress-info w-full" value="85" max="100"></progress>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="card-title text-base font-normal text-base-content/70">Devs Ativos</h2>
                            <p class="text-3xl font-bold mt-2">{{ stats.developers }}</p>
                        </div>
                        <div class="p-3 bg-error/10 rounded-full text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg>
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
                                                    <img :src="task.avatar" alt="Avatar" />
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
                                        <br/>
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

            <div class="card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4 border-b border-base-200 pb-2">Avaliação Geral</h3>
                    
                    <div class="flex items-end gap-2 mb-6">
                        <span class="text-5xl font-bold">4.7</span>
                        <div class="flex flex-col mb-1">
                            <div class="flex text-warning">
                                <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                            <span class="text-xs text-success font-semibold flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                                +0.4 pts
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div v-for="star in [5, 4, 3, 2, 1]" :key="star" class="flex items-center gap-3">
                            <span class="flex items-center gap-1 text-sm w-12">
                                {{ star }} <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-warning fill-current" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </span>
                            <progress 
                                class="progress w-full" 
                                :class="{
                                    'progress-success': star >= 4, 
                                    'progress-warning': star === 3, 
                                    'progress-error': star <= 2 
                                }"
                                :value="star === 5 ? 70 : (star === 4 ? 35 : (star === 3 ? 25 : 10))" 
                                max="100">
                            </progress>
                            <span class="text-xs w-8 text-right opacity-60">
                                {{ star === 5 ? 384 : (star === 4 ? 145 : 20) }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </Layout>
</template>