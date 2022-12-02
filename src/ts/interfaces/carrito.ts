import { Producto } from "./Producto";

type Carrito = Producto & { subtotal: number; qty: number };

export { type Carrito };
