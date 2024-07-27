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
import {Button} from "@/components/ui/button/index.js";
import {Input} from "@/components/ui/input/index.js";
import {computed, ref} from "vue";
import {Save} from 'lucide-vue-next'
import {Checkbox} from "@/components/ui/checkbox/index.js";
import {
    Form as VeeForm,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form/index.js";
import * as yup from "yup";
import {useTableColumn} from "@/hooks/useTableColumn.js";
import {useToast} from "@/components/ui/toast/use-toast";

const props = defineProps(["tableId", "columnId"]);
const open = ref(false);
const {toast} = useToast();

const column = useTableColumn({
    tableId: props.tableId,
    columnId: props.columnId,
});

const schema = yup.object({
    name: yup.string().required("The name field is required"),
    description: yup.string().required("The description field is required"),
    data_type: yup.string().required("The data type field is required"),
    default_value: yup.string().optional().nullable().default("-"),
    is_pk: yup.boolean().default(false),
    is_fk: yup.boolean().default(false),
    is_null: yup.boolean().default(false),
});

const initialValues = computed(() => ({
    name: column.data.nombre,
    description: column.data.descripcion,
    data_type: column.data.tipo_dato,
    default_value: column.data.valor_defecto,
    is_pk: column.data.es_pk === 1,
    is_fk: column.data.es_fk === 1,
    is_null: column.data.es_null === 1,
}))

const onSubmit = async (values) => {
    try {
        await column.update(values);
        open.value = false;
    } catch {
        toast({
            title: 'Error',
            description: 'There was an error while trying to update the column',
            variant: 'destructive'
        })
    }
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot/>
        </DialogTrigger>
        <DialogContent class="max-w-[350px]">
            <DialogHeader>
                <DialogTitle>Edit the column</DialogTitle>
                <DialogDescription>
                    Fill in the form below to edit the table column.
                </DialogDescription>
            </DialogHeader>
            <VeeForm
                :initial-values="initialValues"
                :validation-schema="schema"
                v-slot="{ handleSubmit }"
            >
                <form
                    class="grid gap-4 py-4"
                    @submit.prevent="handleSubmit($event, onSubmit)"
                >
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem class="grid grid-cols-4 items-center gap-x-4">
                            <FormLabel class="text-right">Name</FormLabel>
                            <FormControl>
                                <Input class="col-span-3" v-bind="componentField"/>
                            </FormControl>
                            <FormMessage class="col-span-full place-self-end"/>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="description">
                        <FormItem class="grid grid-cols-4 items-center gap-x-4">
                            <FormLabel class="text-right">Description</FormLabel>
                            <FormControl>
                                <Input class="col-span-3" v-bind="componentField"/>
                            </FormControl>
                            <FormMessage class="col-span-full place-self-end"/>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="data_type">
                        <FormItem class="grid grid-cols-4 items-center gap-x-4">
                            <FormLabel class="text-right">Data type</FormLabel>
                            <FormControl>
                                <Input class="col-span-3" v-bind="componentField"/>
                            </FormControl>
                            <FormMessage class="col-span-full place-self-end"/>
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="default_value">
                        <FormItem class="grid grid-cols-4 items-center gap-x-4">
                            <FormLabel class="text-right">Default value</FormLabel>
                            <FormControl>
                                <Input class="col-span-3" v-bind="componentField"/>
                            </FormControl>
                            <FormMessage class="col-span-full place-self-end"/>
                        </FormItem>
                    </FormField>
                    <div class="flex gap-x-4 justify-end w-full">
                        <FormField
                            v-slot="{ value, handleChange }"
                            type="checkbox"
                            name="is_pk"
                        >
                            <FormItem
                                class="flex flex-row items-start gap-x-3 space-y-0"
                            >
                                <FormControl>
                                    <Checkbox
                                        :checked="value"
                                        @update:checked="handleChange"
                                    />
                                </FormControl>
                                <FormLabel
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    PK
                                </FormLabel>
                            </FormItem>
                        </FormField>
                        <FormField
                            v-slot="{ value, handleChange }"
                            type="checkbox"
                            name="is_fk"
                        >
                            <FormItem
                                class="flex flex-row items-start gap-x-3 space-y-0"
                            >
                                <FormControl>
                                    <Checkbox
                                        :checked="value"
                                        @update:checked="handleChange"
                                    />
                                </FormControl>
                                <FormLabel
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    FK
                                </FormLabel>
                            </FormItem>
                        </FormField>
                        <FormField
                            v-slot="{ value, handleChange }"
                            type="checkbox"
                            name="is_null"
                        >
                            <FormItem
                                class="flex flex-row items-start gap-x-3 space-y-0"
                            >
                                <FormControl>
                                    <Checkbox
                                        :checked="value"
                                        @update:checked="handleChange"
                                    />
                                </FormControl>
                                <FormLabel
                                    class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                >
                                    Null
                                </FormLabel>
                            </FormItem>
                        </FormField>
                    </div>
                    <DialogFooter>
                        <Button type="submit">
                            <Save class="w-4 h-4 mr-2"/>
                            Save
                        </Button>
                    </DialogFooter>
                </form>
            </VeeForm>
        </DialogContent>
    </Dialog>
</template>
