<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Alert from '@/Components/Alert.vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

</script>

<template>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Update Password</h2>
            <div class="text-muted mb-2">
                Ensure your account is using a long, random password to stay secure.
            </div>

            <form @submit.prevent="updatePassword">
                <div class="mb-2">
                    <InputLabel for="current_password" value="Current Password" />

                    <TextInput
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        :hasError="form.errors.current_password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="Your Password"
                    />

                    <InputError :message="form.errors.current_password" />
                </div>

                <div class="mb-2">
                    <InputLabel for="password" value="New Password" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        :hasError="form.errors.password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="New Password"
                    />

                    <InputError :message="form.errors.password"  />
                </div>

                <div class="mb-2">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :hasError="form.errors.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="Confirm New Password"
                    />

                    <InputError :message="form.errors.password_confirmation"  />
                </div>

                <div class="form-footer">
                    <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                </div>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <Alert v-if="form.recentlySuccessful" >Saved.</Alert>
                </Transition>
            </form>
        </div>
    </div>
</template>
