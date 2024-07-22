<script setup>
import {Card, CardDescription, CardHeader, CardTitle} from "@/components/ui/card/index.js";
import EditTableDialog from "@/components/EditTableDialog.vue";

const props = defineProps(["id", 'nombre', 'descripcion'])

</script>

<template>
    <EditTableDialog v-bind="props">
        <Card class="w-[350px] cursor-pointer hover:translate-y-0.5 transition-transform">
            <CardHeader>
                <CardTitle>{{ nombre }}</CardTitle>
                <CardDescription>{{ descripcion }}</CardDescription>
            </CardHeader>
        </Card>
    </EditTableDialog>
</template>
