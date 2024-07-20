export const registerUser = async ({email, name, password}) => {
    await axios.post('/api/register', {
        email,
        name,
        password,
    });
}
