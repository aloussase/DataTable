<script setup>

import ToggleDarkMode from "@/components/ToggleDarkMode.vue";
import {useUser} from "@/hooks/useUser.js";
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
    <nav class="w-full shadow-sm p-2 flex items-center justify-between mb-2">
        <h1>DataTable</h1>
        <div class="flex gap-2">
            <ToggleDarkMode/>
            <div v-if="user">
                <Button @click="signOut">
                    Logout
                </Button>
            </div>
        </div>
    </nav>
</template>

