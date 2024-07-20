<script setup>
import {Button} from '@/components/ui/button'
import {Card, CardContent, CardDescription, CardHeader, CardTitle} from '@/components/ui/card'
import {Input} from '@/components/ui/input'
import {Label} from '@/components/ui/label'
import {ref} from "vue";
import {useUser} from "@/hooks/useUser.js";
import {useRouter} from "vue-router";

const firstName = ref('')
const lastName = ref('');
const email = ref('');
const password = ref('');

const user = useUser();
const router = useRouter();

const signUp = async () => {
    await user.register({
        name: `${firstName.value} ${lastName.value}`,
        email: email.value,
        password: password.value
    })

    await router.push({name: 'sign-in'});
}
</script>

<template>
    <Card class="mx-auto max-w-sm">
        <CardHeader>
            <CardTitle class="text-xl">
                Sign Up
            </CardTitle>
            <CardDescription>
                Enter your information to create an account
            </CardDescription>
        </CardHeader>
        <CardContent>
            <div class="grid gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="first-name">First name</Label>
                        <Input id="first-name" placeholder="Max" required v-model="firstName"/>
                    </div>
                    <div class="grid gap-2">
                        <Label for="last-name">Last name</Label>
                        <Input id="last-name" placeholder="Robinson" required v-model="lastName"/>
                    </div>
                </div>
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        placeholder="m@example.com"
                        required
                        v-model="email"
                    />
                </div>
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" v-model="password"/>
                </div>
                <Button type="submit" class="w-full" @click="signUp">
                    Create an account
                </Button>
            </div>
            <div class="mt-4 text-center text-sm">
                Already have an account?
                <router-link to="/sign-in" class="underline">
                    Sign in
                </router-link>
            </div>
        </CardContent>
    </Card>
</template>
