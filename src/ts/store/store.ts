import { configureStore } from "@reduxjs/toolkit";
import cartSlice from "./context/cart/carritoReducer";
// ...
const store = configureStore({
    reducer: {
        cart: cartSlice.reducer,
    },
    devTools: true,
});

export type RootState = ReturnType<typeof store.getState>;

export default store;
