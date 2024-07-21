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
import {Button} from "@/components/ui/button/index.js";
import {Label} from "@/components/ui/label/index.js";
import {Input} from "@/components/ui/input/index.js";
import {ref} from "vue";
import {Checkbox} from "@/components/ui/checkbox/index.js";
import {useTableColumns} from "@/hooks/useTableColumns.js";

const props = defineProps(["tableId"]);

const tableColumns = useTableColumns(props.tableId);

const open = ref(false)

const name = ref('');
const dataType = ref('');
const isPk = ref(false);
const isFk = ref(false);
const isNull = ref(false);
const defaultValue = ref('');
const description = ref('');

const onSubmit = async () => {
    await tableColumns.create({
        name: name.value,
        data_type: dataType.value,
        is_pk: isPk.value,
        is_fk: isFk.value,
        is_null: isNull.value,
        default_value: defaultValue.value,
        description: description.value,
    });

    open.value = false;

    name.value = '';
    dataType.value = '';
    isPk.value = false;
    isFk.value = false;
    isNull.value = false;
    defaultValue.value = '';
    description.value = '';
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot/>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Create a column</DialogTitle>
                <DialogDescription>
                    Fill in the form below to create a new table column.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="name" class="text-right">
                        Name
                    </Label>
                    <Input id="name" class="col-span-3" v-model="name"/>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="description" class="text-right">
                        Description
                    </Label>
                    <Input id="description" class="col-span-3" v-model="description"/>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="dataType" class="text-right">
                        Data type
                    </Label>
                    <Input id="dataType" class="col-span-3" v-model="dataType"/>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <Label for="defaultValue" class="text-right">
                        Default value
                    </Label>
                    <Input id="defaultValue" class="col-span-3" v-model="defaultValue"/>
                </div>
                <div class="flex gap-x-4 justify-end w-full">
                    <div class="flex items-top gap-2">
                        <Checkbox v-model:checked="isPk" id="isPk"/>
                        <Label
                            for="isPk"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            PK
                        </Label>
                    </div>
                    <div class="flex items-top gap-2">
                        <Checkbox v-model:checked="isFk" id="isFk"/>
                        <Label
                            for="isFk"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            FK
                        </Label>
                    </div>
                    <div class="flex items-top gap-2">
                        <Checkbox v-model:checked="isNull" id="isNull"/>
                        <Label
                            for="isNull"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                            Null
                        </Label>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="onSubmit">
                    Create
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
