<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import LoginLayout from '@/Layouts/LoginLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';

defineProps({
    canRegister: {
        type: Boolean,
    },
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <LoginLayout>
        <Head title="Log in" />

        <Alert :message="status" />

        <form @submit.prevent="submit">
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

            <div class="mb-2">

                <InputLabel for="password">
                    Password
                    <span class="form-label-description">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                        >
                            I forgot password
                        </Link>
                    </span>
                </InputLabel>

                <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    :hasError="form.errors.password"
                    required
                    autocomplete="current-password"
                    placeholder="Your Password"
                />

                <InputError :message="form.errors.password" />
            </div>

            <div class="mb-2">
              <label class="form-check">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="form-check-label">Remember me</span>
              </label>
            </div>

            <div class="form-footer">
                <PrimaryButton :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
          </form>

          <div v-if="canRegister" class="text-center text-muted mt-3">
            Don't have account yet? <Link
                    v-if="canRegister"
                    :href="route('register')"
                    tabindex="-1"
                >Register</Link>
          </div>
    </LoginLayout>
</template>
