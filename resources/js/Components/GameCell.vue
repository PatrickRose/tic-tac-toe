<script setup lang="ts">
const props = defineProps<{ value: 'x' | 'y' | undefined }>();

const emits = defineEmits<{
  makeMove: [];
}>();
</script>

<template>
    <button class="border-4 p-4" @click="emits('makeMove')">
        {{ props.value }}
    </button>
</template>
