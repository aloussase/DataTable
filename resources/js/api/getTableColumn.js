export const getTableColumn = async ({tableId, columnId}) => {
    const response = await axios.get(`/api/tables/${tableId}/columns/${columnId}`);
    return response.data;
}
