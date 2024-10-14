<script setup lang="ts">
import GameBoard from '@/Components/GameBoard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import type { Game } from '@/types/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{ game: Game }>();

const game = ref<Game>(props.game);
</script>

<template>
    <Head title="Game" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Game
            </h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="mx-auto my-2 max-w-7xl bg-white py-2 sm:px-6 lg:px-8"
                >
                    <dl>
                        <dt class="pr-2 font-semibold after:content-[':']">
                            Player 1 (x)
                        </dt>
                        <dd>{{ game.player1?.name }}</dd>
                        <dt class="pr-2 font-semibold after:content-[':']">Player 2 (o)</dt>
                        <dd>
                            <template v-if="game.player2?.name">
                                {{ game.player2.name }}
                            </template>
                            <template v-else>
                              No second player yet.
                              Share this link to get a second player: {{ route('game.join', game.id)}}
                            </template>
                        </dd>
                        <dt class="pr-2 font-semibold after:content-[':']">Turn</dt>
                        <dd>{{ game.moves.length % 2 == 0 ? 'X' : 'O' }}</dd>
                    </dl>
                </div>
                <GameBoard :moves="game.moves" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
