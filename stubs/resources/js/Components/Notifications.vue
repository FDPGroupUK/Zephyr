<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3'

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
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l5 5l10 -10" /></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 8l.01 0" />
                    <path d="M11 12l1 0l0 4l1 0" /></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 9v2m0 4v.01" />
                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 8l0 4" />
                    <path d="M12 16l.01 0" /></svg>
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
