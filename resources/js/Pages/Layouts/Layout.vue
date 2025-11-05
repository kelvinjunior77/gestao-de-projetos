<template>
    <NavBar></NavBar>
    <Header></Header>
    <Main> 
        <template #main-content>
           <slot name="main-content">

           </slot>
        </template>
    </Main>
</template>

<script setup>
import NavBar from './NavBar.vue';
import Header from './Header.vue';
import Main from './Main.vue';
</script>