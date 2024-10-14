<script setup lang="ts">
import { Game } from '@/types/types';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{ games: Game[] }>();

function getOpponent(currId: number, game: Game) {
    if (game.player_1_id == currId) {
        return game.player2?.name ?? 'No opponent';
    } else {
        return game.player1?.name;
    }
}
</script>

<template>
    <div class="m-4 rounded-lg bg-white p-4">
        <h4 class="text-xl font-semibold">
            <slot></slot>
        </h4>
        <table class="w-full">
            <thead>
                <tr>
                    <th>Game ID</th>
                    <th>Opponent</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="game in games" :key="game.id">
                    <td>{{ game.id }}</td>
                    <td>{{ getOpponent($page.props.auth.user.id, game) }}</td>
                    <td>
                        <Link :href="route('game.show', game.id)">
                            Link to game
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
