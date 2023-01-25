<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="card">
            <div class="card-body">
                <div class="markdown">
                    You're logged in!
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
