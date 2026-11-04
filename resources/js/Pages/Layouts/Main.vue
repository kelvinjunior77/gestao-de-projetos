<template>
    <div class="pc-container">
        <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="page-header-title">
                    <h5 class="mb-0 font-medium">Painel ADM</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/index.html">Pagina Inicial</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0)">Painel ADM</a></li>
                    <li class="breadcrumb-item" aria-current="page">Padrão</li>
                </ul>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <slot name="main-content">
           
        </slot>

        </div>

    </div>
</template>

<script setup>


</script>