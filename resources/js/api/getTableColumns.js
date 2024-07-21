export const getTableColumns = async (tableId) => {
    const response = await axios.get(`/api/tables/${tableId}/columns`);
    return response.data;
}
