<template>
    <Head title="Confirm password" />

    <form @submit.prevent="submit">
        <div class="space-y-6">
            <div class="grid gap-2">
                <Label htmlFor="password">Password</Label>
                <Input
                    class="mt-1 block w-full"
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    autocomplete="current-password"
                    autofocus
                />

                <InputError :message="form.errors.password" />
            </div>

            <div class="flex items-center">
                <Button class="w-full" :disabled="form.processing">
                    <LoaderCircle class="h-4 w-4 animate-spin" v-if="form.processing" />
                    Confirm Password
                </Button>
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>
