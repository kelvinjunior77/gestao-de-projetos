<script setup>
import Layout from '../../Layouts/Layout.vue';
import { useForm, Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    projeto: Object,   // projeto atual
    usuarios: Array,   // usuários para atribuir à tarefa
});

const form = useForm({
    titulo: "",
    descricao: "",
    funcao: "",
    status: "pendente",
    prioridade: "media",
    data_fim: "",
    usuarios: [], // usuários atribuídos (IDs)
});

const submit = () => {
    form.post(route("tarefa.store", props.projeto.id));
};
</script>

<template>
    <Layout>
        <div class="max-w-5xl mx-auto">

            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Criar Tarefa</h1>
                <p class="text-base-content/70">
                    Projeto: <strong>{{ projeto.titulo }}</strong>
                </p>
            </div>

            <!-- Card -->
            <div class="card bg-base-100 shadow border border-base-300">
                <div class="card-body space-y-6">

                    <!-- Linha 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="label font-medium">Título</label>
                            <input
                                v-model="form.titulo"
                                type="text"
                                class="input input-bordered w-full"
                                placeholder="Título da tarefa"
                            />
                            <p v-if="form.errors.titulo" class="text-error text-sm">
                                {{ form.errors.titulo }}
                            </p>
                        </div>

                        <div>
                            <label class="label font-medium">Função</label>
                            <input
                                v-model="form.funcao"
                                type="text"
                                class="input input-bordered w-full"
                                placeholder="Ex: Backend, Frontend"
                            />
                        </div>
                    </div>

                    <!-- Linha 2 -->
                    <div>
                        <label class="label font-medium">Descrição</label>
                        <textarea
                            v-model="form.descricao"
                            class="textarea textarea-bordered w-full"
                            rows="4"
                            placeholder="Descrição detalhada da tarefa"
                        ></textarea>
                    </div>

                    <!-- Linha 3 -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="label font-medium">Status</label>
                            <select v-model="form.status" class="select select-bordered w-full">
                                <option value="pendente">Pendente</option>
                                <option value="em_andamento">Em andamento</option>
                                <option value="concluido">Concluído</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <div>
                            <label class="label font-medium">Prioridade</label>
                            <select v-model="form.prioridade" class="select select-bordered w-full">
                                <option value="baixa">Baixa</option>
                                <option value="media">Média</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>

                        <div>
                            <label class="label font-medium">Data final</label>
                            <input
                                v-model="form.data_fim"
                                type="date"
                                class="input input-bordered w-full"
                            />
                        </div>
                    </div>

                    <!-- Usuários -->
                    <div>
                        <label class="label font-medium">
                            Atribuir usuários à tarefa
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label
                                v-for="user in usuarios"
                                :key="user.id"
                                class="flex items-center gap-3 border border-base-300 rounded-lg p-3 cursor-pointer hover:bg-base-200"
                            >
                                <input
                                    type="checkbox"
                                    class="checkbox checkbox-primary"
                                    :value="user.id"
                                    v-model="form.usuarios"
                                />
                                <span class="font-medium">{{ user.name }}</span>
                            </label>
                        </div>

                        <p v-if="form.errors.usuarios" class="text-error text-sm mt-1">
                            {{ form.errors.usuarios }}
                        </p>
                    </div>

                    <!-- Ações -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-base-300">
                        <Link
                            :href="route('projetos.show', projeto.id)"
                            class="btn btn-ghost"
                        >
                            Cancelar
                        </Link>

                        <button
                            class="btn btn-primary px-8"
                            :disabled="form.processing"
                        >
                            Criar Tarefa
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </Layout>
</template>
