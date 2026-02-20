<template>
    <Dashboard :projetos="projectsCount" :tarefas="tasksCount" :projetosFinalizados="finishedProjectsCount" :tarefasFeitas="finishedTasksCount" :tarefasRecentes="tarefasRecentes" :notificacoes="notificacoes" />
</template>

<script setup>
import Dashboard from './Dashboard/Dashboard.vue';

defineProps({
    projectsCount: Number,
    tasksCount: Number,
    finishedProjectsCount: Number,
    finishedTasksCount: Number,
    tarefasRecentes: Array,
    notificacoes: Array,
})
</script>