import { createSlice } from "@reduxjs/toolkit";

interface authState {
    status: "not-authenticated" | "authenticated";
}

const initialState: authState = {
    status: "not-authenticated",
};

export const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        onLogin: (state) => {
            state.status = "authenticated";
        },
        onLogout: (state) => {
            state.status = "not-authenticated";
        },
    },
});

export const { onLogin, onLogout } = authSlice.actions;
export default authSlice;
