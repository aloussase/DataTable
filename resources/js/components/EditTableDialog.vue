<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog/index.js";
import {Input} from "@/components/ui/input";

import {Edit, Plus, Save, X} from "lucide-vue-next";
import {Button} from "@/components/ui/button/index.js";
import {computed, h, ref} from "vue";
import DataTable from "@/components/DataTable.vue";
import CreateColumnDialog from "@/components/CreateColumnDialog.vue";
import {ScrollArea, ScrollBar} from "@/components/ui/scroll-area/index.js";
import * as yup from "yup";
import {ValidationError} from "yup";
import {useTables} from "@/hooks/useTables.js";
import {useToast} from "@/components/ui/toast/use-toast";
import {AxiosError} from "axios";
import EditColumnButton from "@/components/EditColumnButton.vue";

const props = defineProps(["id", "nombre", "descripcion"]);

const isEditingTable = ref(false)
const newTableName = ref(props.nombre)
const newTableDescription = ref(props.descripcion)

const updateTableSchema = yup.object({
    name: yup
        .string()
        .optional()
        .test('is-not-empty', 'Name is required', (value) => value.trim().length > 0),
    description: yup
        .string()
        .optional()
        .test('is-not-empty', 'Description is required', (value) => value.trim().length > 0),
})

const tables = useTables();
const {toast} = useToast();

const editingColumnId = ref(null);

const columns = computed(() => [
    {
        accessorKey: "nombre",
        header: "Nombre",
    },
    {
        accessorKey: "tipo_dato",
        header: "Tipo de dato",
    },
    {
        header: "PK/FK",
        cell: ({row}) => {
            const esPk = row.original["es_pk"];
            const esFk = row.original["es_fk"];

            let value;
            if (esPk && esFk) value = "PK/FK";
            else if (esPk) value = "PK";
            else if (esFk) value = "FK";
            else value = "-";

            return h("div", {class: "text-right"}, value);
        },
    },
    {
        header: "Is not null",
        cell: ({row}) => {
            const isNull = row.original["es_null"];
            return h("div", {}, isNull ? "No" : "Si");
        },
    },
    {
        header: "Valor por defecto",
        accessorKey: "valor_defecto",
    },
    {
        header: "Descripcion",
        accessorKey: "descripcion",
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({row}) => h(EditColumnButton, {
            tableId: props.id,
            columnId: row.original.id
        })
    }
]);

const open = ref(false);

const onEditTable = async () => {
    try {
        const validated = await updateTableSchema.validate({
            tableId: props.id,
            name: newTableName.value,
            description: newTableDescription.value,
        });

        await tables.update(validated);
        isEditingTable.value = false;

        toast({
            title: "Table updated",
            description: `The table '${validated.name}' was updated successfully`,
        });
    } catch (err) {
        if (err instanceof ValidationError)
            toast({title: "Validation error", description: err.errors[0], variant: "destructive"})

        if (err instanceof AxiosError)
            toast({title: "Error", description: err.message, variant: "destructive"})
    }
}

const onCancelEditTable = () => {
    isEditingTable.value = false;
    newTableName.value = props.nombre;
    newTableDescription.value = props.descripcion;
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot/>
        </DialogTrigger>
        <DialogContent class="max-w-[350px] md:max-w-4xl max-h-[90dvh]">
            <DialogHeader>
                <DialogTitle>
                    <div v-if="!isEditingTable" class="flex gap-2 items-center">
                        {{ nombre }}
                        <Edit class="w-4 cursor-pointer" @click="isEditingTable = true"/>
                    </div>
                    <div v-else class="flex gap-2 items-center">
                        <Input type="text" v-model="newTableName" class="min-w-[325px] max-w-fit"/>
                    </div>
                </DialogTitle>
                <DialogDescription>
                    <div v-if="!isEditingTable">
                        Add, edit or remove rows from this table.
                    </div>
                    <div v-else>
                        <Input type="text" v-model="newTableDescription" class="min-w-[325px] max-w-fit"/>
                    </div>
                </DialogDescription>
                <div class="flex gap-2 mt-4 self-start">
                    <CreateColumnDialog :table-id="id">
                        <Button class="w-fit" v-if="!isEditingTable">
                            <Plus class="w-4 h-4 mr-2"/>
                            Add
                        </Button>
                    </CreateColumnDialog>
                    <Button v-if="isEditingTable" class="w-fit" @click="onEditTable">
                        <Save class="w-4 h-4 mr-2"/>
                        Save
                    </Button>
                    <Button v-if="isEditingTable" variant="destructive" @click="onCancelEditTable">
                        <X class="w-4 h-4 mr-2"/>
                        Cancel
                    </Button>
                </div>
            </DialogHeader>
            <ScrollArea v-if="open" class="h-[50dvh] rounded-md w-full">
                <DataTable :table-id="id" :columns="columns"/>
                <ScrollBar orientation="horizontal"/>
            </ScrollArea>
            <DialogFooter>
                <!-- TODO -->
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
