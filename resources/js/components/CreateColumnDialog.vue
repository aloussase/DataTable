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
import { Button } from "@/components/ui/button/index.js";
import { Input } from "@/components/ui/input/index.js";
import { ref } from "vue";
import { Checkbox } from "@/components/ui/checkbox/index.js";
import { useTableColumns } from "@/hooks/useTableColumns.js";
import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/components/ui/form/index.js";
import * as yup from "yup";
import { useForm } from "vee-validate";

const props = defineProps(["tableId"]);

const tableColumns = useTableColumns(props.tableId);

const open = ref(false);

const schema = yup.object({
    name: yup.string().required("The name field is required"),
    description: yup.string().required("The description field is required"),
    data_type: yup.string().required("The data type field is required"),
    default_value: yup.string().optional().default("-"),
    is_pk: yup.boolean().default(false),
    is_fk: yup.boolean().default(false),
    is_null: yup.boolean().default(false),
});

const { handleSubmit } = useForm({
    validationSchema: schema,
    initialValues: schema.getDefault(),
});

const onSubmit = handleSubmit(async (values) => {
    await tableColumns.create(values);
    open.value = false;
});
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent class="max-w-[350px]">
            <DialogHeader>
                <DialogTitle>Create a column</DialogTitle>
                <DialogDescription>
                    Fill in the form below to create a new table column.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem class="grid grid-cols-4 items-center gap-x-4">
                        <FormLabel class="text-right">Name</FormLabel>
                        <FormControl>
                            <Input class="col-span-3" v-bind="componentField" />
                        </FormControl>
                        <FormMessage class="col-span-full place-self-end" />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="description">
                    <FormItem class="grid grid-cols-4 items-center gap-x-4">
                        <FormLabel class="text-right">Description</FormLabel>
                        <FormControl>
                            <Input class="col-span-3" v-bind="componentField" />
                        </FormControl>
                        <FormMessage class="col-span-full place-self-end" />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="data_type">
                    <FormItem class="grid grid-cols-4 items-center gap-x-4">
                        <FormLabel class="text-right">Data type</FormLabel>
                        <FormControl>
                            <Input class="col-span-3" v-bind="componentField" />
                        </FormControl>
                        <FormMessage class="col-span-full place-self-end" />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="default_value">
                    <FormItem class="grid grid-cols-4 items-center gap-x-4">
                        <FormLabel class="text-right">Default value</FormLabel>
                        <FormControl>
                            <Input class="col-span-3" v-bind="componentField" />
                        </FormControl>
                        <FormMessage class="col-span-full place-self-end" />
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
            </div>
            <DialogFooter>
                <Button type="submit" @click="onSubmit"> Create </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
