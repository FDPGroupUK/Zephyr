<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <form @submit.prevent="submit" class="card card-md">
            <div class="card-body">

                <div class="text-muted mb-4">
                    This is a secure area of the application. Please confirm your password before continuing.
                </div>

                <div class="mb-2">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        v-model="form.password"
                        :hasError="form.errors.password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="form-footer">
                    <PrimaryButton :disabled="form.processing">
                        Confirm
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
