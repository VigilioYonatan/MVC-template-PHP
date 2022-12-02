import {
    Component,
    ComponentDad,
    Selector,
    Span,
} from "~/components/components";
import { modalCart } from "~/components/Modal";
import { carritoContext, printProductos } from "~/store/context/cart";

import { BASE_URL, formDataCustom, FormDataInput } from "~/helpers";
import { RegisterUsuario } from "~/interfaces";
import { FormResult, useForm } from "~/hooks";
import { RegisterUsuarioValidacion } from "~/helpers/validations/auth";

/* Documents */
const carritoQty = Selector<HTMLSpanElement>("#carritoQTY");
const formulario = Selector<HTMLFormElement>("#formulario");

/* Variables Global */
let show: boolean = false;

const { printHTML } = carritoContext();

// productosChildren.forEach((a: any) => console.log(a));
/* Components & PrintHMTL */
Component("#cart", () => modalCart({ show }))();
printHTML.printQtyCart();

type ComponentError = {
    padreInput: HTMLDivElement;
    errores: RegisterUsuario;
    name: keyof RegisterUsuario;
};
const componentError = ({ padreInput, errores, name }: ComponentError) => {
    return Component(
        padreInput,
        () =>
            Span({
                textContent: errores[name],
            }),
        2
    )();
};

// printHTML.printQtyCart();

ComponentDad<HTMLDivElement>("#productos", printProductos)();

/* Methods */
const apiOnCrearCuenta = async (datos: RegisterUsuario) => {
    try {
        const formData = formDataCustom(datos);

        const { data } = await BASE_URL.post("/auth/register", formData);
        console.log(data);
    } catch (error) {
        console.log(error);
    }
};

/* Listeners */

carritoQty.addEventListener("click", () => {
    show = !show;
    Component("#cart", () => modalCart({ show }))();
});

const { onSubmit, setError } = useForm<RegisterUsuario>(
    RegisterUsuarioValidacion
);

ComponentDad("#formulario", (elemento: HTMLDivElement) => {
    const input = elemento.querySelector("input") as HTMLInputElement;
    const select = elemento.querySelector("select") as HTMLSelectElement;
    const inputFile = elemento.querySelector(
        "input[type=file]"
    ) as HTMLInputElement;

    const padreInputFile = inputFile?.parentElement as HTMLDivElement;
    inputFile?.addEventListener("change", (e) => {
        const target = e.target as HTMLInputElement;
        const name = inputFile.name as keyof RegisterUsuario;
        const value = target.files as unknown as string;
        const errores = setError({ name, value }) as RegisterUsuario;
        componentError({ padreInput: padreInputFile, errores, name });
    });

    const padreinput = input?.parentElement as HTMLDivElement;
    input?.addEventListener("keyup", (e) => {
        const target = e.target as HTMLInputElement;
        const name = target.name as keyof RegisterUsuario;
        const value = target.value;

        const errores = setError({ name, value }) as RegisterUsuario;
        componentError({ padreInput: padreinput, errores, name });
    });

    const padreselect = select?.parentElement as HTMLDivElement;
    select?.addEventListener("change", (e) => {
        const target = e.target as HTMLSelectElement;
        const name = target.name as keyof RegisterUsuario;
        const value = target.value;
        const errores = setError({ name, value }) as RegisterUsuario;
        componentError({ padreInput: padreselect, errores, name });
    });
})();

formulario.addEventListener("submit", (e) =>
    onSubmit(e, (props: FormResult<RegisterUsuario>) => {
        const { datos, isError, errores, resetForm } = props;
        if (!isError) {
            apiOnCrearCuenta(datos);
            resetForm();
        }
        ComponentDad(formulario, (elemento: HTMLDivElement) => {
            const input = elemento.querySelector("input");
            const select = elemento.querySelector("select");
            if (select) {
                const nameSelect = select?.name as keyof RegisterUsuario;
                const padreselect = select?.parentElement as HTMLDivElement;
                componentError({
                    padreInput: padreselect,
                    errores,
                    name: nameSelect,
                });
            }

            if (input) {
                const name = input.name as keyof RegisterUsuario;
                const padreInput = input?.parentElement as HTMLDivElement;
                componentError({ padreInput, errores, name });
                console.log(select);
            }
        })();
    })
);
