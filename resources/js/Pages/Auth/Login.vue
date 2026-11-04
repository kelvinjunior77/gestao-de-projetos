<script setup>
import { reactive , ref} from "vue";
import { useForm } from "@inertiajs/vue3";

// Form de Login (Inertia)
const login = useForm({
  email: "",
  password: "",
  remember: false,
});

const mostrarSenha = ref(false) 
</script>

<template>
<div class="min-h-screen flex items-center justify-center bg-base-200 relative overflow-hidden">

  <!-- EFEITOS DECORATIVOS -->
  <span class="absolute top-[-120px] right-[-120px] w-[280px] h-[280px] rounded-full 
               bg-primary/20 blur-3xl opacity-40 animate-pulse"></span>

  <span class="absolute bottom-[-120px] left-[-120px] w-[280px] h-[280px] rounded-full 
               bg-secondary/20 blur-3xl opacity-40 animate-pulse"></span>

  <!-- CARD -->
  <div class="card w-full max-w-sm shadow-2xl bg-base-100/80 backdrop-blur-xl border border-base-300/40 relative z-10">
    <div class="card-body p-8">

      <h2 class="text-center text-2xl font-bold mb-6">Bem-vindo</h2>

      <!-- FORM -->
      <form @submit.prevent="login.post('/login')">

        <!-- ERRO -->
        <div v-if="login.errors.mensagem" class="alert alert-error mb-4">
          {{ login.errors.mensagem }}
        </div>

        <!-- EMAIL -->
        <div class="form-control mb-4">
          <label class="label">
            <span class="label-text">Email</span>
          </label>
          <input type="email" v-model="login.email" placeholder="Seu email"
            class="input input-bordered outline-0 w-full" />

          <p v-if="$page.props.errors.email" class="mt-1 text-sm text-red-600">
            {{ $page.props.errors.email }}
          </p>
        </div>

        <!-- SENHA -->
        <div class="form-control mb-4 relative">
          <label class="label">
            <span class="label-text">Senha</span>
          </label>

          <div class="relative w-full flex items-center">
          <input :type="mostrarSenha ? 'text' : 'password'"
            v-model="login.password"
            placeholder="******"
            class="input outline-0 w-full pr-10" />

          <!-- BOTÃO MOSTRAR/OCULTAR -->
          <button type="button"
            class=" text-base-content/60 hover:text-primary transition badge badge-ghost absolute right-2 top-1/2 -translate-y-1/2"
            @click="mostrarSenha = !mostrarSenha">

            <!-- Ícone olho aberto -->
            <svg v-if="mostrarSenha" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
              fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>

            <!-- Ícone olho fechado -->
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
              fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.592M6.18 6.18A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.249 2.592M3 3l18 18" />
            </svg>

          </button>
          </div>

          <p v-if="$page.props.errors.password" class="mt-1 text-sm text-red-600">
            {{ $page.props.errors.password }}
          </p>
        </div>

        <!-- LEMBRAR -->
        <div class="flex items-center justify-between mb-4">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" v-model="login.remember" name="remember" class="checkbox checkbox-primary" />
            <span class="text-sm">Lembrar-me</span>
          </label>

          <a href="#" class="link link-primary text-sm">Esqueceu a senha?</a>
        </div>

        <!-- BOTÃO LOGIN -->
        <button class="btn btn-primary w-full" :disabled="login.processing">
          <span v-if="!login.processing">Entrar</span>
          <span v-else class="loading loading-spinner"></span>
        </button>
      </form>

      <!-- DIVISOR -->
      <div class="divider text-xs">ou continue com</div>

      <!-- LOGIN SOCIAL -->
      <div class="flex flex-col gap-2">

        <!-- GOOGLE -->
        <button class="btn btn-outline w-full gap-2 hover:bg-base-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
            <path fill="#EA4335"
              d="M12 10.2v3.6h5.1c-.2 1.2-.9 2.8-2.1 3.9l3.3 2.6c1.9-1.8 3-4.5 3-7.7 0-.7-.1-1.4-.2-2H12z" />
            <path fill="#34A853"
              d="M12 21c2.7 0 5-1 6.6-2.7l-3.3-2.6c-.9.6-2.1 1-3.3 1-2.5 0-4.6-1.7-5.4-4H3.2v2.5C4.8 18.8 8.1 21 12 21z" />
            <path fill="#4A90E2"
              d="M6.6 12c-.2-.6-.3-1.3-.3-2s.1-1.4.3-2V5.5H3.2C2.4 7.1 2 8.9 2 10.8s.4 3.7 1.2 5.3L6.6 12z" />
            <path fill="#FBBC05"
              d="M12 7.4c1.4 0 2.7.5 3.7 1.5l2.8-2.8C16.9 4.5 14.7 3.6 12 3.6 8.1 3.6 4.8 5.8 3.2 9l3.4 2.6c.8-2.3 2.9-4.2 5.4-4.2z" />
          </svg>
          Entrar com Google
        </button>

        <!-- FACEBOOK -->
        <button class="btn btn-outline w-full gap-2 hover:bg-base-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-blue-600" viewBox="0 0 24 24">
            <path
              d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12" />
          </svg>
          Entrar com Facebook
        </button>

      </div>

      <!-- REGISTRO -->
      <div class="text-center mt-4">
        <span class="text-sm">Não tem conta?</span>
        <a href="/register" class="link link-primary text-sm ml-1">Criar conta</a>
      </div>

    </div>
  </div>
</div>

</template>
