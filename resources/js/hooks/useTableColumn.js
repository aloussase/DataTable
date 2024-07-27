import {useMutation, useQuery, useQueryClient} from "@tanstack/vue-query";
import {getTableColumn} from "@/api/index.js";
import {reactive} from "vue";

export const useTableColumn = ({tableId, columnId}) => {
    const queryClient = useQueryClient();

    const {data} = useQuery({
        queryKey: ["column", columnId],
        queryFn: async () => {
            return await getTableColumn({
                tableId, columnId
            })
        }
    })

    const {mutateAsync: update} = useMutation({
        mutationKey: ["column", columnId],
        mutationFn: async (column) => {
            await axios.patch(`/api/tables/${tableId}/columns/${columnId}`, {
                nombre: column.name,
                descripcion: column.description,
                tipo_dato: column.data_type,
                valor_defecto: column.default_value,
                es_pk: column.is_pk ? 1 : 0,
                es_fk: column.is_fk ? 1 : 0,
                es_null: column.is_null ? 1 : 0,
            })
        },
        onSuccess: async () => {
            await queryClient.invalidateQueries({queryKey: ["column", columnId]})
            await queryClient.invalidateQueries({queryKey: ["tables", tableId]});
        }
    })

    return reactive({
        data,
        update
    })
}
