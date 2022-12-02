import { Component, ComponentDad } from "~/components/components";
import { modalCart } from "~/components/Modal";
import { carritoContext } from "./carritoContext";
import { APIProducto, Carrito } from "~/interfaces";
import { useFetch } from "~/hooks/useFetch";

// let productosId: string[] = [];
let show: boolean = false;

export const printProductos = (elemento: HTMLDivElement) => {
    const id = elemento.dataset.producto as string;

    const { actions } = carritoContext();
    const exist = actions.existeProducto(+id);
    const button = elemento.querySelector("button");
    if (exist) {
        button!.textContent = "Añadido";
    } else {
        button!.textContent = "Add";
    }
    button?.addEventListener("click", async () => {
        const { actions } = carritoContext();
        const exist = actions.existeProducto(+id);

        if (exist) return;

        const { data: producto } = await useFetch<APIProducto, {}>(
            `/productos?id=${id}`
        );

        if (producto?.success && producto.producto.id) {
            const newProductoOnCart: Carrito = {
                ...producto.producto,
                subtotal: producto.producto.precio,
                qty: 1,
            };
            carritoContext().actions.onAddCarrito(newProductoOnCart);
            button.textContent = "Añadido";
            Component("#cart", () => modalCart({ show }))();
        }
    });
};
