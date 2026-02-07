<template>
    <Dashboard :projetos="projectsCount" :tarefas="tasksCount" :projetosFinalizados="finishedProjectsCount" :tarefasFeitas="finishedTasksCount" />
</template>

<script setup>
import Dashboard from './Dashboard/Dashboard.vue';

defineProps({
    projectsCount: Number,
    tasksCount: Number,
    finishedProjectsCount: Number,
    finishedTasksCount: Number,
    
})
</script>