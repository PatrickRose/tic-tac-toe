<script setup lang="ts">
const props = defineProps<{ value: 'x' | 'y' | undefined }>();

const emits = defineEmits<{
    click: [];
}>();
</script>

<template>
    <button class="border-4 p-4" @click="emits.click">
        {{ props.value }}
    </button>
</template>
