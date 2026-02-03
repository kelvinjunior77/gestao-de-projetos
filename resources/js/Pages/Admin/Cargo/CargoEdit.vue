<script setup>
import Layout from "../../Layouts/Layout.vue";
import { useForm, Link, usePage } from "@inertiajs/vue3";
import Navegacao from "../../../Components/Navegacao.vue";
import { ref, computed } from "vue";
import { route } from "ziggy-js";



const props = defineProps({
    cargo: Object
});

const form = useForm({
    nome: props.cargo.nome,
    descricao: props.cargo.descricao,
});


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
                                <Link href="/">
                                Home
                                </Link>
                            </li>

                            <li>
                                <Link href="/admin/lista/cargos">
                                Lista de competência
                                </Link>
                            </li>

                            <li class="font-medium text-primary">
                                Editar Competência
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="col-span-1 xl:col-span-2 card bg-base-100 shadow-sm border border-base-200">
            <div class="max-w-10xl mx-auto p-8">



                <div class="card-body">

                    <div v-if="$page.props.flash.success" role="alert"
                        class="alert alert-success alert-outline mb-6 w-2xl">
                        <span>{{ $page.props.flash.success }}</span>
                    </div>

                    <div v-if="$page.props.flash.error" role="alert" 
                        class="alert alert-error alert-outline" >
                        <span>{{ $page.props.flash.error }}</span>
                    </div>


                    <form @submit.prevent="form.post(`/admin/editar/cargo/${props.cargo.id}`)">
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 w-5xl ">

                            
                            <div class="lg:col-span-2 space-y-6">

                                <!-- NOME -->
                                <div class="form-control">
                                    <label class="label mb-1">
                                        <span class="label-text font-medium">Nome Completo</span>
                                    </label>
                                    <input type="text" v-model="form.nome" placeholder="Nome do usuário"
                                        class="input input-bordered w-full outline-0" />
                                    <p class="text-error text-sm mt-1" v-if="form.errors.nome">{{ form.errors.nome }}
                                    </p>
                                </div>

                                <!-- Descricao -->
                                <div class="form-control">
                                    <label class="label mb-1">
                                        <span class="label-text font-medium">Descrição</span>
                                    </label>
                                
                                        <textarea placeholder="Descrição" name="descricao" id="descricao" v-model="form.descricao" class="textarea input-bordered w-full outline-0">

                                        </textarea>
                                    <p class="text-error text-sm mt-1" v-if="form.errors.descricao">{{ form.errors.descricao }}
                                    </p>
                                </div>

                            </div>                         

                        </div>

                        <!-- BOTÕES -->
                        <div class="mt-10 flex gap-4">
                            <button type="submit" class="btn btn-soft btn-primary px-10" :disabled="form.processing">
                                <span v-if="!form.processing">Salvar Alterações</span>
                                <span v-else class="loading loading-spinner"></span>
                            </button>

                            <button class="btn btn-accent px-10" type="reset" disabled>
                                Limpar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </Layout>
</template>
