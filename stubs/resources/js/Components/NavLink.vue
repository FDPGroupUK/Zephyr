<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() =>
    props.active
        ? 'nav-item active'
        : 'nav-item'
);
</script>

<template>
    <li :class="classes">
        <Link :href="href" class="nav-link">
            <slot />
        </Link>
    </li>
</template>
