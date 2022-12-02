type ElementProps<T extends HTMLElement> = Partial<Omit<T, "style">> & {
    typeHTML: keyof HTMLElementTagNameMap;
    styles?: string;
    add?: Node[];
};

export const Selector = <T extends HTMLElement>(selector: string) =>
    document.querySelector(selector) as T;

const Element = <T extends HTMLElement>({ ...rest }: ElementProps<T>) => {
    const element = document.createElement(rest.typeHTML) as T;
    const elementType = element as any;
    const propsEntries = Object.entries(rest);

    propsEntries.map(([key, value]) => {
        if (key === "styles") {
            elementType.style.cssText = value as string;
        }
        if (typeof elementType[key] === "function") {
            elementType[key](value);
        }
        if (key === "add") {
            const nodeValue = value as Node[];
            for (let i = 0; i < nodeValue.length; i++) {
                elementType.appendChild(nodeValue[i]);
            }
        }
        elementType[key] = value;
    });

    return elementType;
};
type CustomElement<T extends HTMLElement> = Omit<ElementProps<T>, "typeHTML">;

export const Button = ({ ...rest }: CustomElement<HTMLButtonElement>) =>
    Element<HTMLButtonElement>({
        ...rest,
        typeHTML: "button",
    });

export const Div = ({ ...rest }: CustomElement<HTMLDivElement>) =>
    Element<HTMLDivElement>({
        ...rest,
        typeHTML: "div",
    });

export const Span = ({ ...rest }: CustomElement<HTMLSpanElement>) =>
    Element<HTMLSpanElement>({
        ...rest,
        typeHTML: "span",
    });
export const Image = ({ ...rest }: CustomElement<HTMLImageElement>) =>
    Element<HTMLImageElement>({
        ...rest,
        typeHTML: "img",
    });

export const Component = <T extends HTMLElement>(
    element: string | T,
    cb: Function | "",
    children: number = 0
) => {
    return async () => {
        let elementHtml = element as T;
        if (typeof element === "string") {
            elementHtml = Selector<T>(element);
        }

        const childrens = elementHtml.children;
        while (childrens[children]) {
            elementHtml.removeChild(childrens[children]);
        }

        if (typeof cb === "string") {
            elementHtml.prepend("");
            return;
        }
        if (children > 0) {
            elementHtml.appendChild(await cb());
            return;
        }
        elementHtml.prepend(await cb());
    };
};

export const ComponentDad = <T extends HTMLElement>(
    selector: string | T,
    cb: Function
) => {
    return () => {
        let elementHtml = selector as T;
        if (typeof selector === "string") {
            elementHtml = Selector<T>(selector);
        }

        const children = Array.from(elementHtml.children);

        children.forEach((element) => {
            cb(element);
        });
    };
};

export const ComponentDad2 = () => {};
