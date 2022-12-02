import { carritoContext } from "~/store/context/cart";
import {
    Button,
    Component,
    ComponentDad,
    Div,
    Image,
    Span,
} from "./components";

const modalCart = ({ show = true }: { show?: boolean }) => {
    const { carrito, actions } = carritoContext();

    const productoItem = carrito.map((producto) => {
        const { cantidad, title, id, subtotal, qty } = producto;
        return Div({
            className: "cartModal__body",
            add: [
                Span({
                    className: "cartModal__body__title",
                    textContent: title,
                }),
                Image({
                    src: "https://cdn.monstercat.com/share.png",
                    width: 50,
                }),
                Div({
                    add: [
                        Button({
                            textContent: "+",
                            onclick: () => {
                                actions.onAddCarrito(producto);
                                Component("#cart", () => modalCart({}))();
                            },
                        }),
                        Span({ textContent: qty.toString() }),
                        Button({
                            textContent: "-",
                            onclick: () => {
                                actions.onRemoveCarrito(producto);
                                Component("#cart", () => modalCart({}))();
                                ComponentDad<HTMLDivElement>(
                                    "#productos",
                                    (elemento: HTMLDivElement) => {
                                        const button = elemento.querySelector(
                                            "button"
                                        ) as HTMLButtonElement;
                                        const elementId =
                                            elemento.dataset.producto;
                                        if (elementId === id.toString()) {
                                            button.textContent = "Add";
                                        }
                                    }
                                )();
                            },
                        }),
                        Span({ textContent: subtotal.toString() }),
                    ],
                }),
            ],
        });
    });

    const divPadre = Div({
        className: "cartModal",
        styles: show ? "display:block" : "display:none;",
        add: [
            Span({
                className: "cartModal__title",
                textContent: "Carrito",
            }),
            Div({
                add: !carrito.length
                    ? [Span({ textContent: "No hay" })]
                    : [...productoItem],
            }),
        ],
    });

    return divPadre;
};
export { modalCart };
