<script setup lang="ts">
import GameCell from '@/Components/GameCell.vue';

const props = defineProps<{ moves: number[] }>();

function valueOfCell(cell: number): 'x' | 'y' | undefined {
    const position = props.moves.indexOf(cell);

    if (position === -1) {
        return undefined;
    }

    return position % 2 ? 'x' : 'y';
}

const cells = [1, 2, 3, 4, 5, 6, 7, 8, 9];
</script>

<template>
    <div class="grid grid-cols-3">
        <GameCell
            v-for="cell in cells"
            :key="cell"
            :value="valueOfCell(cell)"
        />
    </div>
</template>

<style scoped></style>
