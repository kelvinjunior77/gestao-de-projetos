<script setup>
import { Link, router } from "@inertiajs/vue3";
import { defineProps, computed } from "vue";
import { route } from "ziggy-js";
import { usePage } from "@inertiajs/vue3";

const page = usePage()

// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');
const isNormal = computed(() => page.props.auth.user.tipo === 'normal')

const props = defineProps({
    show: Boolean,
    projeto: Object, // pode vir null
});

</script>

<template>
    <!-- Fundo escuro personalizado -->
    <dialog class="modal" :open="show">
        <!-- Modal em si -->
        <div v-if="projeto" class="modal-box max-w-4xl p-8 rounded-xl shadow-xl border border-base-300 bg-base-100">

            <!-- Cabeçalho -->
            <div class="mb-6">
                <p class="text-sm opacity-70 mb-2">
                    Visualização completa do projeto
                </p>

                <div role="alert"
                    class="alert alert-vertical sm:alert-horizontal bg-base-300 border-0 shadow-sm rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-root-icon lucide-folder-root">
                        <path
                            d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                        <circle cx="12" cy="13" r="2" />
                        <path d="M12 15v5" />
                    </svg>

                    <span class="font-bold">{{ projeto.nome }}</span>

                    <span class="font-bold badge badge-soft flex items-center border-l-2 pl-2
                         border-base-200 line-clamp-1 cursor-pointer" title="Quantidade de tarefas do projeto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-clipboard-list-icon lucide-clipboard-list mr-0">
                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                            <path d="M12 11h4" />
                            <path d="M12 16h4" />
                            <path d="M8 11h.01" />
                            <path d="M8 16h.01" />
                        </svg> {{ projeto.tarefas_count || 0 }}
                    </span>

                    <Link :href="route('usuario.perfil', projeto.user.slug)" class="font-bold badge badge-soft flex items-center
                     border-l-2 pl-2 border-base-200 line-clamp-1 cursor-pointer" title="Criador do projeto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-round-icon lucide-user-round">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>
                        <span class="ml-1">{{ projeto.user.name }}</span>
                    </Link>
                </div>

            </div>

            <!-- Detalhes do Projeto -->
            <div class="space-y-6">

                <!-- DESCRIÇÃO -->
                <div>
                    <h3 class="text-lg font-semibold text-base-content/80">Descrição</h3>
                    <p
                        class="text-sm opacity-80 mt-1 leading-relaxed mb-4 border-l-4 pl-4 border-base-300 bg-base-200 p-4 rounded-lg">
                        {{ projeto?.descricao }}
                    </p>
                    <p class="badge badge-soft badge-info"><span class="font-bold">Repositório: </span> <a
                            :href="projeto?.github_link" target="_blank" class="link link-info">{{ projeto?.github_link
                            }}</a></p>
                </div>

                <div class="divider"></div>

                <!-- INFORMAÇÕES EM GRID -->
                <div class="flex flex-wrap gap-4">

                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-55">
                        <p class="text-base-content/70">Prioridade</p>
                        <p :class="{
                            'capitalize badge badge-soft badge-error': projeto?.prioridade === 'alta',
                            'capitalize badge badge-soft badge-warning': projeto?.prioridade === 'média',
                            'capitalize badge badge-soft badge-success': projeto?.prioridade === 'baixa',
                        }">
                            {{ projeto?.prioridade }}
                        </p>
                    </div>

                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-55">
                        <p class="text-base-content/70">Visibilidade</p>
                        <p :class="{
                            'capitalize badge badge-soft badge-accent': projeto?.visibilidade === 'publico',
                            'capitalize badge badge-ghost': projeto?.visibilidade === 'privado',
                        }">
                            {{ projeto?.visibilidade }}
                        </p>
                    </div>
                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-60">
                        <p class="text-base-content/70">Criado por: </p>
                        <p class="badge badge-info badge-soft capitalize">
                            {{ projeto?.user?.name }}
                        </p>
                    </div>

                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-55">
                        <p class="text-base-content/70">Status</p>
                        <p :class="{
                            'capitalize badge badge-primary badge-soft': projeto?.status === 'em_andamento',
                            'capitalize badge badge-secondary badge-soft': projeto?.status === 'concluido',
                            'capitalize badge badge-accent badge-soft': projeto?.status === 'cancelado',
                        }">
                            {{ projeto?.status }}
                        </p>
                    </div>

                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-55">
                        <p class="text-base-content/70">Data Final</p>
                        <p class="badge badge-secondary badge-soft">
                            {{ projeto?.data_fim ? new Date(projeto.data_fim).toLocaleDateString('pt-BR') : 'Sem prazo'
                            }}
                        </p>
                    </div>

                    <div class="bg-base-300 border-base-200 rounded-lg p-4 flex justify-between items-center h-2 w-60">
                        <p class="text-base-content/70">Criado em</p>
                        <p class="badge badge-primary badge-soft">
                            {{ projeto?.created_at ? new Date(projeto.created_at).toLocaleDateString('pt-BR') :
                                'Semdata' }}
                        </p>
                    </div>


                </div>

                <div class="divider mt-6">
                    <h3 class="font-semibold">Tarefas do Projeto</h3>
                </div>

                <div v-if="projeto?.tarefas?.length" class="flex flex-wrap gap-4">

                    <div v-for="tarefa in projeto.tarefas" :key="tarefa.id"
                        class="p-3 bg-base-200 rounded-lg border border-base-300 h-20">

                        <p class="font-medium text-base-content text-sm mb-2">
                            {{ tarefa.titulo }}
                        </p>

                        <p class="badge badge-soft" :class="{
                            'badge-info': tarefa.status === 'pendente',
                            'badge-primary': tarefa.status === 'em_andamento',
                            'badge-success': tarefa.status === 'concluido',
                            'badge-error': tarefa.status === 'cancelado',
                        }">
                            {{ tarefa.status }}
                        </p>

                    </div>
                </div>

                <p v-else class="text-sm text-base-content/50 italic">
                    Nenhuma tarefa vinculada a este projeto.
                </p>

            </div>

            <div class="divider mt-6"></div>

          
            <div class="modal-action flex justify-between items-center">

               
                <button @click="$emit('close')" class="btn btn-outline">
                    Fechar
                </button>


                <div class="flex gap-4">

                    <Link class="btn btn-soft btn-primary" :href="`/criar/tarefa/${projeto.slug}`">
                        Criar Tarefa
                    </Link>

                </div>


            </div>

        </div>

        <!-- FUNDO DO MODAL -->
        <form method="dialog" class="modal-backdrop bg-black/40">
            <button @click="$emit('close')"></button>
        </form>
    </dialog>

</template>
