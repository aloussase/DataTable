<script setup>

import {Edit} from "lucide-vue-next";
import {Button} from "@/components/ui/button/index.js";
import EditColumnDialog from "@/components/EditColumnDialog.vue";

defineProps(["tableId", "columnId"])
</script>

<template>
    <EditColumnDialog :table-id="tableId" :column-id="columnId">
        <Button class="w-fit" variant="ghost">
            <Edit class="w-4 h-4"/>
        </Button>
    </EditColumnDialog>
</template>
