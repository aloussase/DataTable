<script setup>
import { Button } from "@/components/ui/button";
import {useUser} from "@/hooks/useUser.js";

const user = useUser();
</script>

<template>
    <h1>Hello {{ user.user?.name }}</h1>
    <Button>Hello</Button>
</template>
