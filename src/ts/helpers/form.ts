export const formDataCustom = (valores: object): FormData => {
    const formData = new FormData();
    Object.entries(valores).map(([value, index]) => {
        formData.append(value, index);
    });
    return formData;
};
export type FormDataInput<T extends object> = {
    [a in keyof T]: FormDataEntryValue;
};
