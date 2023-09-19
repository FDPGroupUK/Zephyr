<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3'
import { IconAlertCircle, IconCheck, IconAlertTriangle, IconAlertCircleFilled } from '@tabler/icons-vue';


defineProps({
    showSuccess: {
        type: Boolean,
        default: true
    },
    showInfo: {
        type: Boolean,
        default: true
    },
    showWarning: {
        type: Boolean,
        default: true
    },
    showError: {
        type: Boolean,
        default: true
    },
});

const close = ref(false)

onMounted(() => {
    setTimeout(() => {
        close.value = true
    }, 10000)
})

</script>
<template>
    <div v-if="$page.props.flash.success && showSuccess" class="alert alert-important alert-success alert-dismissible">
        <div class="d-flex">
            <div>
                <IconCheck IconAlertCircle />
            </div>
            <div>
                {{ $page.props.flash.success }}
            </div>
        </div>
        <a class="btn-close btn-close-white" @click="showSuccess = false"></a>
    </div>
    <div v-if="$page.props.flash.info && showInfo" class="alert alert-important alert-info alert-dismissible">
        <div class="d-flex">
            <div>
                <IconAlertCircle />
            </div>
            <div>
                {{ $page.props.flash.info }}
            </div>
        </div>
        <a class="btn-close btn-close-white" @click="showInfo = false"></a>
    </div>
    <div v-if="$page.props.flash.warning && showWarning" class="alert alert-important alert-warning alert-dismissible">
        <div class="d-flex">
            <div>
                <IconAlertTriangle />
            </div>
            <div>
                {{ $page.props.flash.warning }}
            </div>
        </div>
        <a class="btn-close btn-close-white" @click="showWarning = false"></a>
    </div>
    <div class="alert alert-important alert-danger alert-dismissible" v-if="($page.props.flash.error || Object.keys($page.props.errors).length > 0) && showError">
        <div class="d-flex">
            <div>
                <IconAlertCircleFilled />
            </div>
            <div v-if="$page.props.flash.error" class="py-4 text-white text-sm font-medium">{{ $page.props.flash.error }}</div>
            <div v-else class="py-4 text-white text-sm font-medium">
                <span v-if="Object.keys($page.props.errors).length === 1">There is one form error.</span>
                <span v-else>There are {{ Object.keys($page.props.errors).length }} form errors.</span>
            </div>
        </div>
        <a class="btn-close btn-close-white" @click="showError = false"></a>
    </div>
</template>
