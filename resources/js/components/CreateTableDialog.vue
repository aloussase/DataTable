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
import * as yup from 'yup'
import {ref} from "vue";
import {useTables} from "@/hooks/useTables.js";
import {useForm} from "vee-validate";
import {FormControl, FormField, FormItem, FormLabel, FormMessage} from "@/components/ui/form/index.js";
import {useToast} from '@/components/ui/toast/use-toast'

const open = ref(false)
const tables = useTables();

const {toast} = useToast();

const schema = yup.object({
    name: yup.string().required('The name field is required').trim(),
    description: yup.string().required('The description field is required').trim(),
})

const {handleSubmit} = useForm({
    validationSchema: schema
})

const onSubmit = handleSubmit(async (values) => {
    try {
        await tables.create(values);
        open.value = false
        toast({
            title: 'Table created',
            description: `The table '${values.name}' was created successfully`
        })
    } catch {
        toast({
            title: 'Failed to create table',
            description: `There was an error while trying to create the table`
        });
    }
});
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
                <FormField v-slot="{ componentField }" name="name">
                    <FormItem class="grid grid-cols-4 items-center gap-x-4">
                        <FormLabel class="text-right">Name</FormLabel>
                        <FormControl>
                            <Input id="name" class="col-span-3" v-bind="componentField"/>
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
            </div>
            <DialogFooter>
                <Button type="submit" @click="onSubmit">
                    Create
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
