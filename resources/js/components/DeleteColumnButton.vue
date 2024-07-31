<script setup>
import {Trash} from "lucide-vue-next";
import {Button} from "@/components/ui/button";
import {useTableColumn} from "@/hooks/useTableColumn";
import {useToast} from "@/components/ui/toast/use-toast";

const props = defineProps(["tableId", "columnId"])

const column = useTableColumn({
    tableId: props.tableId,
    columnId: props.columnId,
})

const {toast} = useToast()

async function onDelete() {
    try {
        await column.deleteC();
        toast({title: 'Column deleted'})
    } catch {
        toast({
            title: 'Error',
            description: 'There was an error deleting the column',
            variant: 'destructive'
        })
    }
}
</script>

<template>
    <Button class="w-fit" variant="ghost" @click="onDelete">
        <Trash class="w-4 h-4 text-red-400"/>
    </Button>
</template>
