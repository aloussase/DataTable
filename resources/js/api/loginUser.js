export const loginUser = async ({email, password}) => {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/login', {
        email,
        password
    })
}
