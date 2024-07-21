export const createTable = async ({name, description}) => {
    axios.post('/api/tables', {
        nombre: name,
        descripcion: description
    })
}
