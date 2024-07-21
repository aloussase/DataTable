export const getTables = async () => {
    const response = await axios.get('/api/tables');
    return response.data
}
