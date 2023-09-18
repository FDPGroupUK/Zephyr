<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <Alert :message="status" />

        <form @submit.prevent="submit" class="card card-md">
            <div class="card-body">
                <h2 class="text-center mb-4">Forgot password</h2>
                <div class="text-muted mb-4">Enter your email address and your password will be reset and emailed to you.</div>

                <div class="mb-2">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        :hasError="form.errors.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="your@email.com"
                    />

                    <InputError :message="form.errors.email" />
                </div>

                <div class="form-footer">
                    <PrimaryButton :disabled="form.processing">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg> Email Password Reset Link
                    </PrimaryButton>
                </div>
            </div>
        </form>

        <div class="text-center text-muted mt-3">
          Forget it, <Link :href="route('login')" >send me back</Link> to the log in screen.
        </div>
    </GuestLayout>
</template>
