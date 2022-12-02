import { DataForm } from "~/hooks";
import { RegisterUsuario } from "~/interfaces";
import { imagesValidation } from "./customValidation";

const RegisterUsuarioValidacion: DataForm<RegisterUsuario> = {
    nombre: {
        custom: ({ nombre }) => imagesValidation({ images: nombre }),
    },

    email: {
        required: true,
    },
    password: {
        required: true,
    },
    repeatPassword: {
        custom: ({ password, repeatPassword }: RegisterUsuario) => {
            if (password !== repeatPassword) {
                return "No son iguales";
            }
            return true;
        },
        required: true,
    },
};
export { RegisterUsuarioValidacion };
