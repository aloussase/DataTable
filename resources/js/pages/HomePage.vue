<script setup>
import {useUser} from "@/hooks/useUser.js";
import {Button} from "@/components/ui/button";
import {Plus} from 'lucide-vue-next'
import CreateTableDialog from "@/components/CreateTableDialog.vue";
import {useTables} from "@/hooks/useTables.js";
import TableCard from "@/components/TableCard.vue";

const user = useUser();
const tables = useTables();
</script>

<template>
    <div class="mx-auto w-4/5">
        <header class="mb-4">
            <h1 class="text-2xl">Hello, {{ user.user?.name }}</h1>
        </header>
        <main>
            <h2 class="text-xl mb-2">Your tables</h2>
            <CreateTableDialog>
                <Button>
                    <Plus class="w-4 h-4 mr-2"/>
                    Create
                </Button>
            </CreateTableDialog>
            <div class="mt-4 flex gap-3 flex-wrap">
                <TableCard
                    v-for="table of tables.data"
                    :key="table.id"
                    :id="table.id"
                    :nombre="table.nombre"
                    :descripcion="table.descripcion"
                />
            </div>
        </main>
    </div>
</template>
