<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Layout from "../../Layouts/Layout.vue";

const form = useForm({
    name: "",
    email: "",
    password: 12345678,
    cargo: "",
    avatar: null,
});

const avatarPreview = ref(null);

const handleAvatar = (event) => {
    const file = event.target.files[0];
    form.avatar = file;
    if (file) avatarPreview.value = URL.createObjectURL(file);
};
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
                                <Link href="/admin/dashboard">
                                Home
                                </Link>
                            </li>

                            <li class="font-medium text-primary">
                                Cadastrar desenvolvedor
                            </li>
                        </ul>
                    </nav>
                </div>


            </div>
        </div>

        <div class="col-span-1 xl:col-span-2 card bg-base-100 shadow-sm border border-base-200">
            <div class="max-w-10xl mx-auto p-8">



                <div class="card-body">
                    <div role="alert" class="alert alert-success alert-outline mb-6 w-2xl">
                        <span>Cadastrado com sucesso!</span>
                    </div>

                    <!-- GRID PRINCIPAL: Inputs à esquerda / Avatar à direita -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 w-5xl ">

                        <!-- COLUNA ESQUERDA (Inputs ocupam 2/3) -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- NOME -->
                            <div class="form-control">
                                <label class="label mb-1">
                                    <span class="label-text font-medium">Nome Completo</span>
                                </label>
                                <input type="text" v-model="form.name" placeholder="Nome do usuário"
                                    class="input input-bordered w-full outline-0" />
                                <p class="text-error text-sm mt-1" v-if="form.errors.name">{{ form.errors.name }}</p>
                            </div>

                            <!-- EMAIL -->
                            <div class="form-control">
                                <label class="label mb-1">
                                    <span class="label-text font-medium">Email</span>
                                </label>
                                <input type="email" v-model="form.email" placeholder="email@empresa.com"
                                    class="input input-bordered w-full outline-0" />
                                <p class="text-error text-sm mt-1" v-if="form.errors.email">{{ form.errors.email }}</p>
                            </div>

                            <!-- CARGO -->
                            <div class="form-control">
                                <label class="label mb-1">
                                    <span class="label-text font-medium">Cargo</span>
                                </label>

                                <select class="select select-bordered w-full outline-0" v-model="form.cargo">
                                    <option disabled value="">Selecione um cargo</option>
                                    <option value="designer">Designer</option>
                                    <option value="desenvolvedor">Desenvolvedor</option>
                                    <option value="gestor">Gestor</option>
                                    <option value="suporte">Suporte</option>
                                </select>

                                <p class="text-error text-sm mt-1" v-if="form.errors.cargo">{{ form.errors.cargo }}</p>
                            </div>

                            <!-- SENHA -->
                            <div class="form-control">
                                <label class="label mb-1">
                                    <span class="label-text font-medium">Senha Inicial</span>
                                </label>
                                <input type="password" v-model="form.password"
                                    placeholder="Deixe vazio para gerar automaticamente"
                                    class="input input-bordered w-full outline-0" />

                                <p class="text-xs opacity-70 mt-1">Senha padrão.</p>
                                <p class="text-error text-sm" v-if="form.errors.password">{{ form.errors.password }}</p>
                            </div>

                        </div>

                        <!-- COLUNA DIREITA (Avatar 1/3) -->
                        <div class="flex flex-col items-center">

                            <!-- Prévia do Avatar -->
                            <div class="avatar mb-4 group cursor-pointer">
                                <div
                                    class="w-32 h-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2 transition duration-300 group-hover:scale-105">
                                    <img :src="avatarPreview || 'https://placehold.co/200x200?text=Avatar'" />
                                </div>
                            </div>

                            <label class="btn btn-outline btn-sm">
                                Selecionar Foto
                                <input type="file" accept="image/*" class="hidden" @change="handleAvatar" />
                            </label>

                            <p class="text-error text-sm mt-2" v-if="form.errors.avatar">
                                {{ form.errors.avatar }}
                            </p>

                        </div>

                    </div>

                    <!-- BOTÕES -->
                    <div class="mt-10 flex gap-4">
                        <button class="btn btn-primary px-10" :disabled="form.processing"
                            @click="form.post('/admin/cadastrar/usuario')">
                            <span v-if="!form.processing">Cadastrar</span>
                            <span v-else class="loading loading-spinner"></span>
                        </button>

                        <button class="btn btn-accent px-10" @click="form.reset()">
                            Limpar
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </Layout>
</template>
