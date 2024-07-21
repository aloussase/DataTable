export const addTableColumn = async (tableId, columnData) => {
    const response = await axios.post(`/api/tables/${tableId}/columns`, {
        nombre: columnData.name,
        tipo_dato: columnData.data_type,
        descripcion: columnData.description,
        es_pk: columnData.is_pk,
        es_fk: columnData.is_fk,
        es_null: columnData.is_null,
        valor_defecto: columnData.default_value,
    });
    return response.data;
}
