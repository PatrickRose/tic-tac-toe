<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { gameDecode } from '@/types/types';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

const creating = ref<boolean>(false);
const error = ref<string>();

function createGame() {
    if (creating.value) {
        return;
    }

    creating.value = true;
    error.value = undefined;

    axios
        .post(route('game.store'))
        .then((response) => {
            const data = response.data;

            const game = gameDecode.parse(data);

            router.visit(route('game.show', game.id));
        })
        .catch((e) => {
            error.value = 'Unable to create game, please wait and try again';
            console.error(e);
        })
        .finally(() => (creating.value = false));
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h3 class="text-xl">Games</h3>
                <div
                    v-if="error"
                    class="my-2 rounded-2xl bg-red-400 p-4 text-red-900"
                >
                    {{ error }}
                </div>

                <button
                    class="rounded-2xl bg-blue-600 px-2 text-white"
                    @click="createGame"
                    :disabled="creating"
                >
                    Create new game
                    <template v-if="creating">
                        <br />
                        Creating game, please wait...
                    </template>
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
