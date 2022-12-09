<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="btn btn-danger w-100"
    >
        <slot />
    </button>
</template>
