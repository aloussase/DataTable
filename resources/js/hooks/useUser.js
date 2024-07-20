import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {getMe} from "@/api/getMe.js";
import {registerUser} from "@/api/registerUser.js";
import {loginUser} from "@/api/loginUser.js";
import {reactive} from "vue";
import {logoutUser} from "@/api/logoutUser.js";

export const useUser = () => {
    const queryClient = useQueryClient();

    const {data} = useQuery({
        queryKey: ['users'],
        queryFn: getMe
    })

    const {mutateAsync: register} = useMutation({
        mutationKey: ['users'],
        mutationFn: registerUser,
        onSuccess: async () => {
            await queryClient.invalidateQueries('users')
        }
    })

    const {mutateAsync: login} = useMutation({
        mutationKey: ['users'],
        mutationFn: loginUser,
        onSuccess: async () => {
            await queryClient.invalidateQueries('users')
        }
    })

    const {mutateAsync: logout} = useMutation({
        mutationKey: ['users'],
        mutationFn: logoutUser,
        onSuccess: async () => {
            await queryClient.invalidateQueries('users')
        }
    })

    return reactive({
        user: data,
        register,
        login,
        logout,
    })
}
