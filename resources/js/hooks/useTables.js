import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {createTable, getTables} from "@/api";
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
            await queryClient.invalidateQueries("tables");
        }
    })

    return reactive({
        create,
        data
    });
}
