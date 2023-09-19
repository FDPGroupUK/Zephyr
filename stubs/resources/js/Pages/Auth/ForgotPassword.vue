<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';
import { IconMail } from '@tabler/icons-vue';

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
                        <IconMail /> Email Password Reset Link
                    </PrimaryButton>

                </div>
            </div>
        </form>

        <div class="text-center text-muted mt-3">
          Forget it, <Link :href="route('login')" >send me back</Link> to the log in screen.
        </div>
    </GuestLayout>
</template>
