const imagesValidation = ({
    images,
    size = 1000000,
    types = ["image/jpeg", "image/png", "image/jpg", "image/webp"],
}: {
    images: string;
    size?: number;
    types?: string[];
}) => {
    const imagenes = images as unknown as File[];
    if (!imagenes.length) return "Imagen obligatorioa";
    const imagenesFormated = imagenes.length
        ? (imagenes as File[])
        : [imagenes];

    for (const imagen of imagenesFormated) {
        const img = imagen as File;
        if (!types.includes(img.type)) {
            return `${img.name} Formato no válido`;
        }
        if (img.size > size) {
            return `${img.name} Imagen muy pesado`;
        }
    }
    return true;
};

export { imagesValidation };
