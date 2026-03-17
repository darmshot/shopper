import {AlpineGlobal} from "@/types/alpine";

declare global {
    const Alpine: AlpineGlobal;
    interface Window {
        Alpine: AlpineGlobal
    }
}


export {}
