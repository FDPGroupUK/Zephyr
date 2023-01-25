<script setup>
import { onMounted, ref, computed } from 'vue';

const props = defineProps(['modelValue', 'hasError']);

defineEmits(['update:modelValue']);

const input = ref(null);

const classes = computed(() =>
    props.hasError
        ? 'form-control is-invalid'
        : 'form-control'
);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        :class="classes"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
