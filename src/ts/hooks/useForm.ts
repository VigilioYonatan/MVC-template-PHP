import { FormDataInput } from "~/helpers";

interface ErroresFormValueRequired {
    value: boolean;
    msg?: string;
}
interface ErroresFormValuePattern {
    value: RegExp;
    msg: string;
}
interface ErroresFormLength {
    value: number;
    msg?: string;
}
interface customFormValueError<T, U> {
    name: keyof T;
    nameDato: string;
    valueErrorMessage: U;
}
export type FormResult<T> = {
    datos: T;
    errores: T;
    isError: boolean;
    resetForm: () => void;
};
interface ErroresForm<T> {
    required?: ErroresFormValueRequired | boolean;
    pattern?: ErroresFormValuePattern;
    minLength?: ErroresFormLength;
    maxLength?: ErroresFormLength;
    onlyNumbers?: ErroresFormValueRequired | boolean;
    onlyLetters?: ErroresFormValueRequired | boolean;
    custom?: (data: T) => boolean | string;
}
export type DataForm<T> = {
    [key in keyof T]: ErroresForm<T> | boolean;
};

const useForm = <T extends object>(data: DataForm<T>) => {
    let errores: { [key in keyof T]: string } | {} = {};

    const required = (
        rest: customFormValueError<T, ErroresFormValueRequired>
    ) => {
        if (!rest.nameDato && !rest.nameDato.length) {
            addError({
                name: rest.name,
                msg: rest.valueErrorMessage.msg || "Este campo es obligatorio",
            });
        }
    };
    const pattern = (
        rest: customFormValueError<T, ErroresFormValuePattern>
    ) => {
        if (!rest.valueErrorMessage.value.test(rest.nameDato)) {
            addError({
                name: rest.name,
                msg: rest.valueErrorMessage.msg,
            });
        }
    };

    const minLength = (rest: customFormValueError<T, ErroresFormLength>) => {
        const value = rest.valueErrorMessage.value;
        const msg = rest.valueErrorMessage.msg;
        if (value < rest.nameDato.length) {
            addError({
                name: rest.name,
                msg: msg || `Minimo ${value} carácteres`,
            });
        }
    };
    const maxLength = (rest: customFormValueError<T, ErroresFormLength>) => {
        const value = rest.valueErrorMessage.value;
        const msg = rest.valueErrorMessage.msg;
        if (value > rest.nameDato.length) {
            addError({
                name: rest.name,
                msg: msg || `Máximo ${value} carácteres`,
            });
        }
    };
    const onlyLetters = (
        rest: customFormValueError<T, ErroresFormValueRequired>
    ) => {
        const regx = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+(?: [a-zA-ZáéíóúÁÉÍÓÚñÑ]+)*$/;
        if (!regx.test(rest.nameDato)) {
            addError({
                name: rest.name,
                msg:
                    rest.valueErrorMessage.msg ||
                    "Este campo solo permite letras",
            });
        }
    };
    const onlyNumbers = (
        rest: customFormValueError<T, ErroresFormValueRequired>
    ) => {
        const regx = /^[0-9]+/;
        if (!regx.test(rest.nameDato)) {
            addError({
                name: rest.name,
                msg:
                    rest.valueErrorMessage.msg ||
                    "Este campo solo permite números",
            });
        }
    };

    const addError = ({ name, msg }: { name: keyof T; msg: string }) => {
        errores = {
            ...errores,
            [name]: msg,
        };
    };
    const customed = (cb: Function, name: keyof T) => {
        const resultado = cb();
        if (typeof resultado === "string") {
            errores = {
                ...errores,
                [name]: resultado,
            };
        }
    };
    const validations = {
        required,
        pattern,
        minLength,
        maxLength,
        onlyLetters,
        onlyNumbers,
    };
    const validaciones = (datos: T) => {
        Object.entries(datos).forEach(([key]) => {
            const valores = { [key]: "" };
            errores = { ...errores, ...valores };
        });
        Object.entries(data).forEach(([key, value]) => {
            const tipo = value as ErroresForm<T>;
            const name = key as keyof T;
            if (tipo) {
                Object.entries(tipo).forEach(
                    ([tipoError, valueErrorMessage]) => {
                        const nameDato = datos[name] as string;

                        if (tipoError === "custom") {
                            customed(() => valueErrorMessage(datos as T), name);
                            return;
                        }
                        if (valueErrorMessage) {
                            const config = {
                                name,
                                nameDato,
                                valueErrorMessage,
                            };

                            validations[
                                tipoError as keyof Omit<
                                    ErroresForm<T>,
                                    "custom"
                                >
                            ](config);
                        }
                    }
                );
            }
        });

        return errores;
    };

    const onSubmit = (e: SubmitEvent, cb: Function) => {
        e.preventDefault();
        const target = e.target as HTMLFormElement;

        const datos = Object.fromEntries(
            new FormData(target)
        ) as FormDataInput<T>;

        const resetForm = () => target.reset();

        const errores = validaciones(datos as T);
        /* Hay errores? */
        const isError: boolean = Object.values(errores).join("").length > 0;
        /* cb  */
        cb({ datos, errores, isError, resetForm } as FormResult<T>);
    };
    let datosNew = {} as T;
    const setError = (customData: { name: keyof T; value: string }) => {
        const datas = Object.keys(data);
        for (const data of datas) {
            datosNew = { ...datosNew, [data]: "" };
        }
        datosNew = { ...datosNew, [customData.name]: customData.value };


        return validaciones(datosNew);
    };
    return { onSubmit, setError };
};

export { useForm };
