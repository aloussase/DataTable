<script setup>
import {Button} from '@/components/ui/button'
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from '@/components/ui/card'
import {Input} from '@/components/ui/input'
import {Label} from '@/components/ui/label'
import {ref} from "vue";
import {useUser} from "@/hooks/useUser.js";
import {useRouter} from "vue-router";

const email = ref('')
const password = ref('')

const user = useUser();
const router = useRouter();

const signIn = async () => {
    await user.login({
        email: email.value,
        password: password.value
    })

    await router.push({name: 'home'})
}
</script>

<template>
    <div class="flex items-center justify-center">
        <Card class="w-full max-w-sm">
            <CardHeader>
                <CardTitle class="text-2xl">
                    Login
                </CardTitle>
                <CardDescription>
                    Enter your email below to login to your account.
                </CardDescription>
            </CardHeader>
            <CardContent class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" type="email" placeholder="m@example.com" required v-model="email"/>
                </div>
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required v-model="password"/>
                </div>
                <Button class="w-full" @click="signIn">
                    Sign in
                </Button>
                <div class="mt-4 text-center text-sm">
                    Don't have an account?
                    <router-link to="/sign-up" class="underline">
                        Sign up
                    </router-link>
                </div>
            </CardContent>
        </Card>
    </div>
</template>

<style scoped>

</style>
