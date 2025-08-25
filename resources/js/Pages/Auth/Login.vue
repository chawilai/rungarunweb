<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
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
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="alert alert-success mb-4">{{ status }}</div>

        <form @submit.prevent="submit" class="space-y-4">
          <div class="form-control">
            <label class="label" for="email"><span class="label-text">Email</span></label>
            <input id="email" type="email" v-model="form.email" required autofocus autocomplete="username" class="input input-bordered w-full" />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="form-control">
            <label class="label" for="password"><span class="label-text">Password</span></label>
            <input id="password" type="password" v-model="form.password" required autocomplete="current-password" class="input input-bordered w-full" />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <label class="label cursor-pointer justify-start gap-2">
            <Checkbox name="remember" v-model:checked="form.remember" />
            <span class="label-text">Remember me</span>
          </label>

          <div class="flex items-center justify-between pt-2">
            <Link v-if="canResetPassword" :href="route('password.request')" class="link link-hover text-sm">Forgot your password?</Link>
            <PrimaryButton class="ms-auto" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Log in</PrimaryButton>
          </div>
        </form>
    </GuestLayout>
</template>
