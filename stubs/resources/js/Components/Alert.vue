<script setup>
import { ref } from 'vue';
import { IconAlertCircle } from '@tabler/icons-vue';

const props = defineProps({
    message: {
        type: String,
    },
});

const close = ref(false);
</script>

<template>
    <div v-if="!close && props.message" class="alert alert-important alert-success alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <IconAlertCircle />
        </div>
        <div>
          {{ props.message }}
        </div>
      </div>
      <a @click="close = !close" class="btn-close btn-close-white" aria-label="close"></a>
    </div>
</template>
