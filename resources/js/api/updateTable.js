export const updateTable = async ({tableId, name, description}) => {
    const response = await axios.patch(`/api/tables/${tableId}`, {
        nombre: name,
        descripcion: description
    });
    return response.data;
}
