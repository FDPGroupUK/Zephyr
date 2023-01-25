<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Alert from '@/Components/Alert.vue';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Profile Information</h2>
            <div class="text-muted mb-2">
                Update your account's profile information and email address.
            </div>

            <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
                <div class="alert alert-info alert-dismissible" role="alert">
                  <h3 class="mb-1">Unverified email</h3>
                  <p>Your email address is unverified.</p>
                  <Link
                        :href="route('verification.send')"
                        method="post"
                        class="btn btn-primary"
                    >
                        Click here to re-send the verification email.
                    </Link>
                  <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="mt-3">
                    <Alert
                        v-show="props.status === 'verification-link-sent'"
                        message="A new verification link has been sent to your email address."
                    />
                </Transition>
            </div>

            <form @submit.prevent="form.patch(route('profile.update'))" >

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
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-2">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        :hasError="form.errors.email"
                        required
                        autocomplete="email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="form-footer">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="mt-3">
                    <Alert v-if="form.recentlySuccessful" message="Saved."/>
                </Transition>
            </form>
        </div>
    </div>
</template>
