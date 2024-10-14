<script setup lang="ts">
import GameBoard from '@/Components/GameBoard.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Game, gameDecode } from '@/types/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, onUnmounted, ref } from 'vue';

const props = defineProps<{ game: Game }>();

const game = ref<Game>(props.game);

const makingMove = ref<boolean>(false);

function parseAxiosResponse(response: axios.AxiosResponse<any>) {
    const data = response.data;

    game.value = gameDecode.parse(data);
}

function makeMove(move: number) {
    if (makingMove.value) {
        return;
    }

    makingMove.value = true;

    axios
        .post(route('game.move', props.game.id), {
            move: move,
        })
        .then(parseAxiosResponse)
        .catch((e) => {
            console.error(e);
        })
        .finally(() => (makingMove.value = false));
}

let refresh: null | ReturnType<typeof setInterval> = null;

function getGameState() {
    axios
        .get(route('game.get', props.game.id))
        .then(parseAxiosResponse)
        .catch((e) => {
            console.error(e);
        })
        .finally(() => (makingMove.value = false));
}

onMounted(() => {
    // Refresh game state every 3 seconds
    // Would use websockets, but not enough time
    refresh = setInterval(getGameState, 3000);
});

onUnmounted(() => {
    if (refresh) {
        clearInterval(refresh);
    }
});
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
                        <dt class="pr-2 font-semibold after:content-[':']">
                            Player 2 (o)
                        </dt>
                        <dd>
                            <template v-if="game.player2?.name">
                                {{ game.player2.name }}
                            </template>
                            <template v-else>
                                No second player yet. Share this link to get a
                                second player: {{ route('game.join', game.id) }}
                            </template>
                        </dd>
                        <dt class="pr-2 font-semibold after:content-[':']">
                            Turn
                        </dt>
                        <dd>{{ game.moves.length % 2 == 0 ? 'X' : 'O' }}</dd>
                    </dl>
                    <div>Game will refresh every 3 seconds :)</div>
                </div>
                <GameBoard :moves="game.moves" @makeMove="makeMove" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
