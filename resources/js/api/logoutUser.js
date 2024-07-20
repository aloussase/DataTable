export const logoutUser = async () => {
    await axios.post("/api/logout")
}
