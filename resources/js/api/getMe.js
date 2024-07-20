export const getMe = async () => {
    try {
        const res = await axios.get('/api/users/me');
        return res.data;
    } catch {
        return null
    }
}
