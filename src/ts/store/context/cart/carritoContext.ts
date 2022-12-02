import { Carrito } from "~/interfaces";
import store from "~/store/store";
import { addCarrito, changeQty, removeCarrito } from "./carritoReducer";

let carritoQty = document.getElementById("carritoQTY") as HTMLSpanElement;
const carritoContext = () => {
    const { carrito } = store.getState().cart;

    const onAddCarrito = (producto: Carrito) => {
        const existe = existeProducto(producto.id);
        if (existe?.qty === producto.cantidad) return;
        if (existe) {
            store.dispatch(changeQty({ ...producto, qty: producto.qty + 1 }));
        } else {
            store.dispatch(addCarrito(producto));
        }
        const { carrito } = store.getState().cart;
        carritoQty.textContent = carrito.length.toString();
        localStorage.setItem("carrito", JSON.stringify(carrito) ?? "[]");
    };

    const onRemoveCarrito = (product: Carrito) => {
        const producto = existeProducto(product.id) as Carrito;
        if (producto!.qty <= 1) {
            store.dispatch(removeCarrito(product.id));
        } else {
            store.dispatch(changeQty({ ...producto, qty: producto.qty - 1 }));
        }
        const { carrito } = store.getState().cart;

        carritoQty.textContent = carrito.length.toString();
        localStorage.setItem("carrito", JSON.stringify(carrito) ?? "[]");
    };

    const existeProducto = (id: number) =>
        carrito.find((carrito) => carrito.id === id);

    /* Prints HTML */
    const printQtyCart = () => {
        const { carrito } = store.getState().cart;
        carritoQty.textContent = carrito.length.toString();
    };

    return {
        carrito,
        actions: { onAddCarrito, onRemoveCarrito, existeProducto },
        printHTML: { printQtyCart },
    };
};
export { carritoContext };
