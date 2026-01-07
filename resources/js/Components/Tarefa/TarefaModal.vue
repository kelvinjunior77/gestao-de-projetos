<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  show: Boolean,
  tarefa: Object,
})

defineEmits(['close'])
</script>

<template>
  <dialog class="modal" :open="show">
    <!-- Fundo mais suave -->
    <div class="modal-backdrop bg-black/40" @click="$emit('close')"></div>

    <!-- Modal -->
    <div
      v-if="tarefa"
      class="modal-box max-w-4xl p-6 rounded-2xl border border-base-300 shadow-xl"
    >
      <!-- Header -->
      <div class="flex justify-between items-start mb-6">
        <div>
          <h3 class="text-2xl font-bold text-primary">
            {{ tarefa.titulo }}
          </h3>
          <p class="text-sm text-base-content/60">
            Projeto: <strong>{{ tarefa.projeto?.nome }}</strong>
          </p>
        </div>

        <button class="btn btn-sm btn-circle" @click="$emit('close')">✕</button>
      </div>

      <!-- Conteúdo -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Coluna esquerda -->
        <div class="space-y-4">
          <div>
            <p class="font-semibold text-base-content/70">Descrição</p>
            <p class="text-base-content">
              {{ tarefa.descricao || '—' }}
            </p>
          </div>

          <div>
            <p class="font-semibold text-base-content/70">Função</p>
            <p>{{ tarefa.funcao || '—' }}</p>
          </div>

          <div>
            <p class="font-semibold text-base-content/70">Criado por</p>
            <p>{{ tarefa.user?.name }}</p>
          </div>
        </div>

        <!-- Coluna direita -->
        <div class="space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="font-semibold text-base-content/70">Status</p>
              <span class="badge badge-info">{{ tarefa.status }}</span>
            </div>

            <div>
              <p class="font-semibold text-base-content/70">Prioridade</p>
              <span class="badge badge-warning">{{ tarefa.prioridade }}</span>
            </div>
          </div>

          <div>
            <p class="font-semibold text-base-content/70">Data final</p>
            <p>{{ tarefa.data_fim ?? 'Sem prazo' }}</p>
          </div>

          <div>
            <p class="font-semibold text-base-content/70">Usuários atribuídos</p>
            <div class="flex flex-wrap gap-2 mt-1">
              <span
                v-for="user in tarefa.usuarios"
                :key="user.id"
                class="badge badge-outline"
              >
                {{ user.name }}
              </span>
            </div>
          </div>
        </div>

      </div>

      <!-- Ações -->
      <div class="modal-action mt-8">
        <button class="btn btn-ghost" @click="$emit('close')">
          Fechar
        </button>

        <Link
          :href="route('tarefa.create', tarefa.projeto?.slug)"
          class="btn btn-primary"
        >
          Criar nova tarefa
        </Link>
      </div>
    </div>
  </dialog>
</template>
