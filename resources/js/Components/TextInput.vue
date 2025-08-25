\<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="input input-bordered w-full focus:outline-none focus:ring-0 focus:shadow-none focus:ring-offset-0"
        v-model="model"
        ref="input"
    />
</template>
