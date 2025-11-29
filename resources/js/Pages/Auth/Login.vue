<script setup>
import { reactive } from "vue";
import { useForm } from "@inertiajs/vue3";

// Form de Login (Inertia)
const login = useForm({
  email: "",
  password: "",
  remember_token: false,
});
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-base-200 relative overflow-hidden">

    <!-- EFEITOS DECORATIVOS -->
    <span
      class="absolute top-[-120px] right-[-120px] w-[280px] h-[280px] rounded-full bg-primary/20 blur-xl opacity-40 animate-pulse"></span>
    <span
      class="absolute bottom-[-120px] left-[-120px] w-[280px] h-[280px] rounded-full bg-secondary/20 blur-xl opacity-40 animate-pulse"></span>

    <!-- CARD -->
    <div class="card w-full max-w-sm shadow-xl bg-base-100 relative z-10">
      <div class="card-body p-8">

        <!-- LOGO 
        <div class="text-center mb-6">
          <img
            src="/assets/images/logo-dark.svg"
            class="h-10 mx-auto"
            alt="Logo"
          />
        </div>-->

        <h2 class="text-center text-xl font-semibold mb-4">Login</h2>

        <!-- FORM -->
        <form @submit.prevent="login.post('/login')">

          <div v-if="login.errors.mensagem" class="alert alert-error mt-0 mb-4">
            {{ login.errors.mensagem }}
          </div>
          <div class="form-control mb-3">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" v-model="login.email" placeholder="Seu email" class="input input-bordered  outline-0 w-full" />

            <p v-if="$page.props.errors.email" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.email }}
            </p>
          </div>

          <div class="form-control mb-2">
            <label class="label">
              <span class="label-text">Senha</span>
            </label>
            <input type="password" v-model="login.password" placeholder="******" class="input input-bordered outline-0 w-full" />

            <p v-if="$page.props.errors.password" class="mt-1 text-sm text-red-600">
              {{ $page.props.errors.password }}
            </p>
          </div>

          <div class="flex items-center justify-between mb-4">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="remember" class="checkbox checkbox-primary" checked />
              <span class="text-sm">Lembrar-me</span>
            </label>

            <a href="#" class="link link-primary text-sm">Esqueceu a senha?</a>
          </div>

          <button class="btn btn-primary w-full" :disabled="login.processing">
            <span v-if="!login.processing">Entrar</span>
            <span v-else class="loading loading-spinner"></span>
          </button>
        </form>

        <div class="text-center mt-4">
          <span class="text-sm">Não tem conta ?</span>
          <a href="/register" class="link link-primary text-sm ml-1">
            Criar conta
          </a>
        </div>

      </div>
    </div>
  </div>
</template>
