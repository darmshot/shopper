import {AlpineMagic} from "@/types/alpine";

export function useMagic<T extends object>(ctx: object): T & AlpineMagic {
    return ctx as T & AlpineMagic;
}
