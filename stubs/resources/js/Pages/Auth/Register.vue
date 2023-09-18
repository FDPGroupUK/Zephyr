<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit" class="card card-md">
            <div class="card-body">
                <h2 class="text-center mb-4">Create new account</h2>

                <div class="mb-2">
                    <InputLabel for="name" value="Name" />

                    <TextInput
                        id="name"
                        type="text"
                        v-model="form.name"
                        :hasError="form.errors.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Your Name"
                    />

                    <InputError :message="form.errors.name" />
                </div>

                <div class="mb-2">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        :hasError="form.errors.email"
                        required
                        autocomplete="username"
                        placeholder="your@email.com"
                    />

                    <InputError :message="form.errors.email" />
                </div>

                <div class="mb-2">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        v-model="form.password"
                        :hasError="form.errors.password"
                        required
                        autocomplete="new-password"
                        placeholder="Your Password"
                    />

                    <InputError :message="form.errors.password" />
                </div>

                <div class="mb-2">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        :hasError="form.errors.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm Password"
                    />

                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div class="form-footer">
                    <PrimaryButton :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </div>
        </form>

        <div class="text-center text-muted mt-3">
          Already have account? <Link :href="route('login')" >Log in</Link>
        </div>
    </GuestLayout>
</template>
