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
                                Lista de Desenvolvedores
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


          
            <div class="col-span-1 xl:col-span-2 card bg-base-100 shadow-sm border border-base-200">
                <div class="card-body p-0">
                    <div class="p-5 border-b border-base-200">
                        <h3 class="font-bold text-lg">Desenvolvedores</h3>
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
   </Layout>
</template>

<script setup>
import Layout from '../../Layouts/Layout.vue';

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