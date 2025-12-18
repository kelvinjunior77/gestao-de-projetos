<script setup>
import { Link, router} from "@inertiajs/vue3";
import { defineProps, computed } from "vue";
import { route } from "ziggy-js";

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

                <h2 class="text-3xl font-bold text-primary">
                    {{ projeto?.nome }}
                </h2>
               
            </div>

            <!-- Detalhes do Projeto -->
            <div class="space-y-6">

                <!-- DESCRIÇÃO -->
                <div>
                    <h3 class="text-lg font-semibold text-base-content/80">Descrição</h3>
                    <p class="opacity-80 mt-1 leading-relaxed mb-4">
                        {{ projeto?.descricao }}
                    </p>
                    <p class="badge badge-soft badge-info">Repositório: <a :href="projeto?.github_link" target="_blank"
                            class="link link-info">{{ projeto?.github_link }}</a></p>
                </div>

                <div class="divider"></div>

                <!-- INFORMAÇÕES EM GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-base-content/70">Prioridade</p>
                        <p :class="{
                            'capitalize badge badge-soft badge-error': projeto?.prioridade === 'alta',
                            'capitalize badge badge-soft badge-warning': projeto?.prioridade === 'média',
                            'capitalize badge badge-soft badge-success': projeto?.prioridade === 'baixa',
                        }">
                            {{ projeto?.prioridade }}
                        </p>
                    </div>                

                    <div>
                        <p class="text-base-content/70">Visibilidade</p>
                        <p :class="{
                            'capitalize badge badge-soft badge-accent': projeto?.visibilidade === 'publico',
                            'capitalize badge badge-ghost': projeto?.visibilidade === 'privado',
                        }">
                            {{ projeto?.visibilidade }}
                        </p>
                    </div>
                    <div>
                        <p class="text-base-content/70">Criado por</p>
                        <p class="badge badge-info badge-soft capitalize">
                            {{ projeto?.user?.name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-base-content/70">Data Final</p>
                        <p class="badge badge-secondary badge-soft">
                            {{ projeto?.data_fim }}
                        </p>
                    </div>

                    <div>
                        <p class="text-base-content/70">Criado em</p>
                        <p class="badge badge-primary badge-soft">
                            {{ new Date(projeto.created_at).toISOString().slice(0, 10) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-base-content/70">Última atualização</p>
                        <p class="badge badge-secondary badge-soft">
                            {{ new Date(projeto.updated_at).toISOString().slice(0, 10) }}
                        </p>
                    </div>

                </div>
            </div>

            <div class="divider mt-6"></div>

            <!-- RODAPÉ DO MODAL -->
            <div class="modal-action flex justify-between items-center">

                <!-- Botão fechar -->
                <button @click="$emit('close')" class="btn btn-outline">
                    Fechar
                </button>


                <div class="flex gap-4">
                    <Link class="btn btn-info" :href="`/projetos/lista/tarefas?projeto=${projeto.slug}`">
                        Ver Tarefas
                    </Link>

                    <!-- Link para criar tarefa -->    
                    <Link class="btn btn-primary" :href="`/criar/tarefa/${projeto.slug}`">
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
