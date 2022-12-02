interface Usuario {
    id: number;
    nombre: string;
    email: string;
    password: string;
}

type RegisterUsuario = Omit<Usuario, "id"> & { repeatPassword: string };

export { type Usuario, type RegisterUsuario };
