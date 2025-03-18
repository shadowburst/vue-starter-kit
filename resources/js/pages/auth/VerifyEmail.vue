<template>
    <Head title="Email verification" />

    <Form @submit="resend()">
        <LoadingButton type="submit" variant="secondary" :loading="resendForm.processing">
            Resend verification email
        </LoadingButton>
        <Link :href="route('logout')" method="post" as="button"> Log out </Link>
    </Form>

    <Form @submit="submit()">
        <PinInput
            v-model="form.code"
            type="number"
            required
            otp
            placeholder="○"
            ref="codeRef"
            :disabled="form.processing"
            @complete="submit()"
        >
            <PinInputGroup>
                <PinInputInput class="size-14 text-xl" v-for="(key, index) in 6" :key :index />
            </PinInputGroup>
        </PinInput>
    </Form>
</template>

<script setup lang="ts">
import LoadingButton from '@/components/app/button/LoadingButton.vue';
import { Form } from '@/components/ui/form';
import { Link } from '@/components/ui/link';
import { PinInput, PinInputGroup, PinInputInput } from '@/components/ui/pin-input';
import { SharedData } from '@/types';
import { VerifyCodeRequest } from '@/types/backend';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

type Props = SharedData;
defineProps<Props>();

const resendForm = useForm({});

function resend() {
    resendForm.post(route('verification.send'));
}

const codeRef = ref<HTMLInputElement>();

const form = useForm({
    code: [] as string[],
}).transform((data): VerifyCodeRequest => ({ code: data.code.join('') }));

function submit() {
    form.post(route('verification.code'), {
        onError: () => form.reset(),
    });
}
</script>
