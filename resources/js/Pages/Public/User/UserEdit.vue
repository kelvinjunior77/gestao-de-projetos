<script setup>
import { useForm, Link, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import Layout from "../../Layouts/Layout.vue";
import { route } from "ziggy-js";
import Navegacao from "../../../Components/Navegacao.vue";

const page = usePage();

// Atalho para verificar permissão de admin e usuario normal.
const isAdmin = computed(() => page.props.auth.user.tipo === 'admin');
const isNormal = computed(() => page.props.auth.user.tipo === 'normal')

const props = defineProps({
    user: Object,
    cargos: {
        type: Array,
        required: true
    }
});

// Form de edição já preenchido
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    cargo: props.user.cargo,
    tipo: props.user.tipo,
    avatar: null,
});

// Preview atual ou novo
const avatarPreview = ref(
    props.user.avatar
        ? `/storage/${props.user.avatar}`
        : "https://placehold.co/200x200?text=Avatar"
);

const handleAvatar = (event) => {
    const file = event.target.files[0];
    if (!file) return;

    form.avatar = file;
    avatarPreview.value = URL.createObjectURL(file);
};
</script>

<template>

    <Layout>


        <div class="max-w-10xl h-10 mb-6">
            <div
                class="flex flex-col md:flex-row md:items-center justify-between bg-base-100 border border-base-200 rounded-xl px-1 py-1 shadow-sm">

                <Navegacao :link="route('admin.list.usuarios')" title="Lista de usuarios" pagina_ativo=" Editar usuário"
                    :user="user" />
            </div>
        </div>





        <div class="p-6 max-w-10xl mx-auto">

            <!-- CARD -->
            <form @submit.prevent="form.post(`/usuario/editar/${props.user.id}`)">

                <div class="card bg-base-100 shadow-md border border-base-200 p-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


                        <!-- DADOS DO USUARIO (COLUNA ESQUERDA - 2 COLUNAS) -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nome -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium">Nome</span>
                                </label>
                                <input v-model="form.name" type="text" class="input input-bordered outline-0 w-full"
                                    placeholder="Nome do usuário" />
                                <p v-if="form.errors.name" class="text-error text-sm mt-1">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium">Email</span>
                                </label>
                                <input v-model="form.email" type="email" class="input input-bordered outline-0 w-full"
                                    placeholder="email@empresa.com" />
                                <p v-if="form.errors.email" class="text-error text-sm mt-1">
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <!-- Cargo -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="font-medium">Cargo</span>
                                </label>
                                <select v-model="form.cargo" class="select select-bordered outline-0 w-full">
                                    <option v-for="(nome, id) in cargos" :key="id" :value="nome">
                                        {{ nome }}
                                    </option>
                                </select>

                                <p v-if="form.errors.cargo" class="text-error text-sm mt-1">
                                    {{ form.errors.cargo }}
                                </p>

                            </div>

                            <!-- Tipo -->
                            <div v-if="isAdmin" class="form-control">
                                <label class="label">
                                    <span class="font-medium">Tipo de Usuário</span>
                                </label>
                                <select v-model="form.tipo" class="select select-bordered outline-0 w-full">
                                    <option value="admin">Administrador</option>
                                    <option value="normal">Normal</option>
                                </select>

                                <p v-if="form.errors.tipo" class="text-error text-sm mt-1">
                                    {{ form.errors.tipo }}
                                </p>
                            </div>

                            <!-- Senha -->
                            <div v-if="$page.props.auth.user.id === user.id" class="form-control">
                                <label class="label">
                                    <span class="font-medium">Nova Senha</span>
                                </label>
                                <input v-model="form.password" type="password"
                                    class="input input-bordered outline-0 w-full" placeholder="Digite a nova senha" />
                                <p v-if="form.errors.password == 'A senha deve ter pelo menos 6 caracteres.'"
                                    class="text-error text-sm mt-1">
                                    {{ form.errors.password }}
                                </p>
                            </div>


                            <div v-if="$page.props.auth.user.id === user.id" class="form-control">
                                <label class="label">
                                    <span class="font-medium">Confirmar Senha</span>
                                </label>
                                <input v-model="form.password_confirmation" type="password"
                                    class="input input-bordered outline-0 w-full" placeholder="Confirme a nova senha" />
                                <p v-if="form.errors.password == 'A confirmação da senha não corresponde.'"
                                    class="text-error text-sm mt-1">
                                    {{ form.errors.password }}
                                </p>
                            </div>
                        </div>

                        <!-- AVATAR (COLUNA DIREITA) -->
                        <div class="flex flex-col items-center justify-start">

                            <img :src="avatarPreview" alt="Avatar do Usuário"
                                class="w-32 h-32 rounded-full shadow object-cover ring ring-primary ring-offset-base-100 ring-offset-2" />

                            <label class="btn btn-outline btn-sm mt-4">
                                Trocar Foto
                                <input type="file" class="hidden" accept="image/*" @change="handleAvatar" />
                            </label>

                            <p v-if="form.errors.avatar" class="text-error text-sm mt-1">
                                {{ form.errors.avatar }}
                            </p>
                        </div>
                    </div>

                    <!-- BOTÕES -->
                    <div class="flex items-center mt-8 gap-4">

                        <button class="btn btn-primary px-8" :disabled="form.processing">
                            <span v-if="!form.processing">Salvar Alterações</span>
                            <span v-else class="loading loading-spinner"></span>
                        </button>



                        <Link v-if="isAdmin" :href="route('admin.list.usuarios')" class="btn btn-ghost">
                        Voltar
                        </Link>

                        <Link v-if="isNormal" :href="route('usuario.lista')" class="btn btn-ghost">
                        Voltar
                        </Link>
                    </div>

                </div>
            </form>

        </div>
    </Layout>
</template>
