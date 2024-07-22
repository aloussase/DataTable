<script setup>

import ToggleDarkMode from "@/components/ToggleDarkMode.vue";
import {useUser} from "@/hooks/useUser.js";
import {Github} from 'lucide-vue-next'
import {Button} from "@/components/ui/button/index.js";
import {useRouter} from "vue-router";

const user = useUser();
const router = useRouter();

const signOut = async () => {
    await user.logout();
    await router.push({name: 'sign-in'})
}
</script>

<template>
    <nav class="w-full shadow-sm p-2 px-4 flex items-center justify-between mb-2">
        <h1>DataTable</h1>
        <div class="flex gap-2 items-center">
            <ToggleDarkMode/>
            <a href="https://github.com/aloussase/DataTable" target="_blank">
                <Button variant="ghost">
                    <Github class="h-4 w-4"/>
                </Button>
            </a>
            <div v-if="user">
                <Button @click="signOut" variant="ghost">
                    Logout
                </Button>
            </div>
        </div>
    </nav>
</template>

