<script setup>
import NavBar from './NavBar.vue'; // Sua Sidebar Lateral
import Header from './Header.vue'; // Seu Topo

</script>

<template>
    <div class="flex h-screen w-full bg-base-200 text-base-content overflow-hidden">
        
        <NavBar class="shrink-0 hidden lg:flex" />

        <div class="flex flex-col flex-1 w-full transition-all duration-300">
            
            <Header />

            
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 bg-base-200/50 relative">
                
                <slot />
                
            </main>
        </div>
        
        </div>
</template>