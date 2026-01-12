<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js';

defineProps({
  show: Boolean,
  tarefa: Object,
})

defineEmits(['close'])
</script>

<template>
  <dialog class="modal" :open="show">

    <div class="modal-backdrop bg-black/40" @click="$emit('close')"></div>

    <div v-if="tarefa" class="modal-box max-w-4xl p-6 rounded-2xl border border-base-300 shadow-xl">
      <!-- Header -->
      <div class="flex justify-between items-start mb-6 bg-base-300 p-4 rounded-lg">
        <div>
          <h3 class="text-2xl font-bold text-info flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              class="lucide lucide-folder-root-icon lucide-folder-root">
              <path
                d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
              <circle cx="12" cy="13" r="2" />
              <path d="M12 15v5" />
            </svg>
            {{ tarefa.titulo }}
          </h3>
          <p class="text-sm text-base-content/60 mt-2">
            Projeto: <strong>{{ tarefa.projeto?.nome }}</strong>
          </p>
        </div>

        <button class="btn btn-sm btn-circle" @click="$emit('close')">✕</button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Coluna esquerda -->
        <div class="space-y-4">
          <div class="bg-base-200 p-4 rounded-lg">
            <p class="font-semibold text-base-content/70 ">Descrição</p>
            <p class="text-sm mt-2">
              {{ tarefa.descricao || '—' }}
            </p>
          </div>

          <div class="bg-base-200 p-4 rounded-lg">
            <p class="font-semibold text-base-content/70">Função</p>
            <p class="text-sm mt-2">{{ tarefa.funcao || '—' }}</p>
          </div>

          <div class="bg-base-200 p-4 rounded-lg">
            <p class="font-semibold text-base-content/70 mb-2">
              Criado por
            </p>

            <Link :href="route('usuario.perfil', { slug: tarefa.user.slug })" v-if="tarefa.user" class="flex items-center gap-3 px-3 py-2 border border-base-300 
               rounded-xl bg-base-100 shadow-sm w-fit">

              <div class="avatar">
                <div class="w-10 h-10 rounded-full ring ring-base-300">
                  <img v-if="tarefa.user.avatar" :src="`/storage/${tarefa.user.avatar}`" :alt="tarefa.user.name" />
                  <div v-else class="flex items-center justify-center bg-primary text-primary-content font-bold">
                    {{ tarefa.user.name.charAt(0).toUpperCase() }}
                  </div>
                </div>
              </div>


              <div class="flex flex-col leading-tight">
                <span class="text-sm font-semibold">
                  {{ tarefa.user.name }}
                </span>
                <span class="text-xs text-base-content/60">
                  {{ tarefa.user.cargo ?? 'Sem cargo' }}
                </span>
              </div>

            </Link>

            <p v-else class="text-sm opacity-60">
              Usuário não identificado
            </p>
          </div>

        </div>

        <!-- Coluna direita -->
        <div class="space-y-4 bg-base-200 p-4 rounded-lg">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="font-semibold text-base-content/70">Status</p>
              <span class="badge badge-soft badge-error">{{ tarefa.status }}</span>
            </div>

            <div>
              <p class="font-semibold text-base-content/70">Prioridade</p>
              <span class="badge badge-soft badge-warning">{{ tarefa.prioridade }}</span>
            </div>

            <div>
              <p class="font-semibold text-base-content/70">Data final</p>
              <p class="text-sm">{{ tarefa.data_fim ? new Date(tarefa.data_fim).toLocaleDateString('pt-BR') : 'Sem prazo' }}</p>
            </div>

            <div>
              <p class="font-semibold text-base-content/70">Data Criação</p>
              <p class="text-sm"> {{ tarefa?.created_at
                ? new Date(tarefa.created_at).toLocaleDateString('pt-BR')
                : 'Sem data'
                }} </p>
            </div>
          </div>

          <div>
            <p class="font-semibold text-base-content/70 mb-2">
              Usuários atribuídos
            </p>

            <div class="flex flex-wrap gap-3">
              <div v-for="user in tarefa.usuarios" :key="user.id"
                class="flex items-center gap-3 px-3 py-2 border border-base-300 rounded-xl bg-base-100 shadow-sm">
                <Link :href="route('usuario.perfil', { slug: user.slug })" class="flex items-center gap-3">
                  <div class="avatar">
                    <div class="w-10 h-10 rounded-full ring ring-base-300">
                      <img v-if="user.avatar" :src="`/storage/${user.avatar}`" :alt="user.name" />
                      <div v-else class="flex items-center justify-center bg-primary text-primary-content font-bold">
                        {{ user.name.charAt(0).toUpperCase() }}
                      </div>
                    </div>
                  </div>

                  <!-- Nome + Cargo -->
                  <div class="flex flex-col leading-tight">
                    <span class="text-sm font-semibold">
                      {{ user.name }}
                    </span>
                    <span class="text-xs text-base-content/60">
                      {{ user.cargo ?? 'Sem cargo' }}
                    </span>
                  </div>
                </Link>

              </div>
            </div>
          </div>

        </div>

      </div>

      <!-- Ações -->
      <div class="modal-action mt-8">
        <button class="btn btn-ghost" @click="$emit('close')">
          Fechar
        </button>

        <Link :href="route('tarefa.create', tarefa.projeto?.slug)" class="btn btn-soft btn-primary">
          Criar nova tarefa
        </Link>
      </div>
    </div>
  </dialog>
</template>
