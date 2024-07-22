<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from "@/components/ui/dialog/index.js";

import {Plus} from 'lucide-vue-next'
import {Button} from "@/components/ui/button/index.js";
import {h, ref} from "vue";
import DataTable from "@/components/DataTable.vue";
import CreateColumnDialog from "@/components/CreateColumnDialog.vue";
import {ScrollArea} from "@/components/ui/scroll-area/index.js";

const props = defineProps(["id", "nombre", "descripcion"])

const columns = [
    {
        accessorKey: 'nombre',
        header: 'Nombre'
    },
    {
        accessorKey: 'tipo_dato',
        header: 'Tipo de dato',
    },
    {
        header: 'PK/FK',
        cell: ({row}) => {
            const esPk = row.original['es_pk'];
            const esFk = row.original['es_fk'];

            let value
            if (esPk && esFk) value = 'PK/FK'
            else if (esPk) value = 'PK'
            else if (esFk) value = 'FK'
            else value = '-'

            return h('div', {class: 'text-right'}, value)
        }
    },
    {
        header: 'Is not null',
        cell: ({row}) => {
            const isNull = row.original['es_null'];
            return h('div', {}, isNull ? 'No' : 'Si')
        }
    },
    {
        header: 'Valor por defecto',
        accessorKey: 'valor_defecto'
    },
    {
        header: 'Descripcion',
        accessorKey: 'descripcion'
    }
]

const open = ref(false)
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot/>
        </DialogTrigger>
        <DialogContent class="max-w-4xl max-h-[90dvh]">
            <DialogHeader>
                <DialogTitle>{{ nombre }}</DialogTitle>
                <DialogDescription>
                    Add, edit or remove rows from this table.
                </DialogDescription>
                <div class="mt-4">
                    <CreateColumnDialog :table-id="id">
                        <Button class="w-fit">
                            <Plus class="w-4 h-4 mr-2"/>
                            Add
                        </Button>
                    </CreateColumnDialog>
                </div>
            </DialogHeader>
            <ScrollArea v-if="open" class="h-[50dvh] rounded-md w-full">
                <DataTable :table-id="id" :columns="columns"/>
            </ScrollArea>
            <DialogFooter>
                <!-- TODO -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
