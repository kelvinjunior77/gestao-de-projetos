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

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-primary">
                    Editar Tarefa
                </h1>
                <p class="text-base-content/70 mt-1">
                    Projeto:
                    <strong>{{ tarefa.projeto?.nome }}</strong>
                </p>
            </div>

            <!-- Conteúdo principal -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- COLUNA ESQUERDA -->
                <div class="card bg-base-100 shadow-md border border-base-300">
                    <div class="card-body space-y-5">

                        <!-- Título -->
                        <div>
                            <label class="label font-semibold">Título</label>
                            <input v-model="form.titulo" type="text" class="input input-bordered w-full" />
                            <p v-if="form.errors.titulo" class="text-error text-sm">
                                {{ form.errors.titulo }}
                            </p>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label class="label font-semibold">Descrição</label>
                            <textarea v-model="form.descricao" rows="4" class="textarea textarea-bordered w-full" />
                        </div>

                        <!-- Função -->
                        <div>
                            <label class="label font-semibold">Função</label>
                            <textarea v-model="form.funcao" rows="3" class="textarea textarea-bordered w-full" />
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
                                <select v-model="form.status" class="select select-bordered w-full">
                                    <option value="pendente">Pendente</option>
                                    <option value="em_andamento">Em andamento</option>
                                    <option value="concluido">Concluído</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>

                            <!-- Prioridade -->
                            <div>
                                <label class="label font-semibold">Prioridade</label>
                                <select v-model="form.prioridade" class="select select-bordered w-full">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>

                            <!-- Data final -->
                            <div>
                                <label class="label font-semibold">Data final</label>
                                <input v-model="form.data_fim" type="date" class="input input-bordered w-full" />
                            </div>

                        </div>

                        <!-- Usuários -->
                        <div>
                            <label class="label font-semibold mb-2">
                                Usuários atribuídos
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <label v-for="user in usuarios" :key="user.id" class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer
                   hover:bg-base-200 transition">
                                    <!-- Checkbox -->
                                    <input type="checkbox" class="checkbox checkbox-primary" :value="user.id"
                                        v-model="form.usuarios" />

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        <div class="w-9 h-9 rounded-full ring ring-base-300">
                                            <img v-if="user.avatar" :src="`/storage/${user.avatar}`"
                                                :alt="user.name" />

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
