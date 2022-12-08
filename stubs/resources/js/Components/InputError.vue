<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message" class="invalid-feedback">
        {{ message }}
    </div>
</template>
