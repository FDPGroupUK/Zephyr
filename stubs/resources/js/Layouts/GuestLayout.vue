<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>

    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <Link href="/" class="navbar-brand navbar-brand-autodark">
                <ApplicationLogo heigh="36"/>
            </Link>
        </div>

        <slot />
      </div>
    </div>
</template>
