<template>

    <div>
       <h1>
    Ola
</h1>

 <Link href="/login"> <h2>Login</h2> </Link>
 <Link href="/logout" method="post"> <h2>sair</h2> </Link> 
    </div>

<!----
  <div v-if="$page.props.auth.user" style="display: none;">
            <div class="">
                <p>ID do usuário: {{ $page.props.auth.user.id }}</p>
                <p>Nome: {{ $page.props.auth.user.name }}</p>
            </div>
        </div>--->


</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>