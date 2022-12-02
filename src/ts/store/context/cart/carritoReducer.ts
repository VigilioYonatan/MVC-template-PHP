import { createSlice } from "@reduxjs/toolkit";
import type { PayloadAction } from "@reduxjs/toolkit";
import { Carrito } from "~/interfaces";

export interface CartState {
    carrito: Carrito[];
}

const initialState: CartState = {
    carrito: JSON.parse(localStorage.getItem("carrito") ?? "[]") as Carrito[],
};

const cartSlice = createSlice({
    name: "cart",
    initialState,
    reducers: {
        addCarrito: (state, action: PayloadAction<Carrito>) => {
            state.carrito = [...state.carrito, action.payload];
        },
        removeCarrito: (state, action: PayloadAction<number>) => {
            state.carrito = state.carrito.filter(
                (producto) => producto.id !== action.payload
            );
        },
        changeQty: (state, action: PayloadAction<Carrito>) => {
            state.carrito = state.carrito.map((producto) => {
                if (producto.id === action.payload.id) {
                    const qty = action.payload.qty;
                    return {
                        ...action.payload,
                        qty,
                        subtotal: action.payload.precio * qty,
                    };
                }
                return producto;
            });
        },
    },
});

export const { addCarrito, removeCarrito, changeQty } = cartSlice.actions;
export default cartSlice;
