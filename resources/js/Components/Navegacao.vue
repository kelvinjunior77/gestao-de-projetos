<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    link: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    pagina_ativo: {
        type: String,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <div>
        <!-- Breadcrumb -->
        <nav class="text-sm breadcrumbs mt-1 p-2 opacity-70">
            <ul>
                <li>
                    <Link href="/">
                    Home
                    </Link>
                </li>

                <li>
                    <Link :href="props.link">
                    {{ props.title }}
                    </Link>
                </li>

                <li v-if="$page.props.auth.user.id === props.user.id" class="font-medium text-primary">
                    Editar meu perfil
                </li>
                <li v-else class="font-medium text-primary">
                    {{ props.pagina_ativo }}
                </li>



            </ul>
        </nav>
    </div>

</template>