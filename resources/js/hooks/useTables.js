import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {createTable, getTables, updateTable} from "@/api";
import {reactive} from "vue";

export const useTables = () => {
    const queryClient = useQueryClient();

    const {data} = useQuery({
        queryKey: ["tables"],
        queryFn: getTables,
        initialData: []
    })

    const {mutateAsync: create} = useMutation({
        mutationFn: createTable,
        mutationKey: ["tables"],
        onSuccess: async () => {
            await queryClient.invalidateQueries({
                queryKey: ["tables"]
            });
        }
    })

    const {mutateAsync: update} = useMutation({
        mutationKey: ["tables"],
        mutationFn: updateTable,
        onSuccess: async () => {
            await queryClient.invalidateQueries({
                queryKey: ["tables"]
            })
        }
    })

    return reactive({
        create,
        update,
        data
    });
}
