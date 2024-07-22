<script setup>
import Navbar from "@/components/Navbar.vue";
import Toaster from "@/components/ui/toast/Toaster.vue";
</script>

<template>
    <Navbar/>
    <Toaster/>
    <router-view/>
</template>
