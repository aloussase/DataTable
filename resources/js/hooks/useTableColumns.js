import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {addTableColumn, getTableColumns} from "@/api/index.js";
import {reactive} from "vue";

export const useTableColumns = (tableId) => {
    const queryClient = useQueryClient()

    const {data} = useQuery({
        queryKey: ["tables", tableId],
        queryFn: async () => await getTableColumns(tableId),
        initialData: [],
    })

    const {mutateAsync: create} = useMutation({
        mutationKey: ["tables", tableId],
        mutationFn: async (columnData) => await addTableColumn(tableId, columnData),
        onSuccess: async () => {
            await queryClient.invalidateQueries({
                queryKey: ["tables", tableId]
            });
        }
    })

    return reactive({
        data,
        create
    })
}
