<script setup>
import {Button} from "@/components/ui/button/index.js";
import {Input} from "@/components/ui/input/index.js";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from "@/components/ui/dialog/index.js";
import {Label} from "@/components/ui/label/index.js";
import {ref} from "vue";
import {useTables} from "@/hooks/useTables.js";

const name = ref('')
const description = ref('')

const open = ref(false)

const tables = useTables();

const onSubmit = async () => {
    await tables.create({
        name: name.value,
        description: description.value
    })

    name.value = ''
    description.value = ''
    open.value = false
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot/>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Create a table</DialogTitle>
                <DialogDescription>
                    Fill in the form below to create a new table.
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
            </div>
            <DialogFooter>
                <Button type="submit" @click="onSubmit">
                    Create
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
