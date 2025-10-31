<template>
    <NavBar></NavBar>
    <Header></Header>
    <Main > 
        <template #main-content>
            <slot>
                
            </slot>
        </template>
    </Main>
</template>

<script setup>
import NavBar from '../Dashboard/NavBar.vue';
import Header from '../Dashboard/Header.vue';
import Main from '../Dashboard/Main.vue';
</script>