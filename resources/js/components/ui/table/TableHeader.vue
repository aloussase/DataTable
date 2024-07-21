<script setup>
import {cn} from "@/lib/utils";

const props = defineProps({
    class: {type: null, required: false},
});
</script>

<template>
    <thead :class="cn('sticky top-0 bg-secondary [&_tr]:border-b', props.class)">
    <slot/>
    </thead>
</template>
