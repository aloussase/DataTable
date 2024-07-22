export const createTable = async ({name, description}) => {
    await axios.post('/api/tables', {
        nombre: name,
        descripcion: description
    })
}
