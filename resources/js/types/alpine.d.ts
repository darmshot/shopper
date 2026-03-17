// Core "this" type inside Alpine components
export interface AlpineMagic {
    $root: HTMLElement
    $el: HTMLElement
    $refs: Record<string, HTMLElement>
    $watch: (prop: string, callback: (value: any) => void) => void
    $dispatch: (event: string, detail?: any) => void
    $nextTick: (callback: () => void) => void
    $id: (name: string, key?: string | number) => string
    $store: Record<string, any>
    init: () => void
    $notify: (type: 'success' | 'danger' | 'info' | 'warning', message: string) => void;
    // [key: string]: any // allow custom magic
}

// Component instance type
export type AlpineComponent<T extends object = any> = T & AlpineMagic

// data() factory callback
export type AlpineDataCallback<T extends object = any> =
    (this: AlpineComponent<T>, ...args: any[]) => T

// store() value type
export type AlpineStoreValue = Record<string, any> | any

// Directive handler
export type AlpineDirectiveHandler = (
    el: HTMLElement,
    value: any,
    modifiers: string[],
    expression: string,
    effect: (callback: () => void) => void
) => void

// Plugin type
export type AlpinePlugin = (alpine: AlpineGlobal) => void

// Main Alpine global interface
export interface AlpineGlobal {
    // Register a component

/*    data<T extends object = {}>(
        name: string,
        callback: (this: AlpineComponent<T>, props?: Partial<T>) => T
    ): void*/

    // Reactive store
    store(name: string, value: AlpineStoreValue): void
    store<T = any>(name: string): T

    // Magic properties
    magic(
        name: string,
        callback: (el: HTMLElement) => any
    ): void

    // Directives (x-*)
    directive(
        name: string,
        callback: AlpineDirectiveHandler
    ): void

    // Plugins
    plugin(plugin: AlpinePlugin): void

    // Start Alpine
    start(): void

    // Re-scan DOM
    initTree(root: HTMLElement): void

    // Evaluate expressions
    evaluate(
        el: HTMLElement,
        expression: string,
        extras?: Record<string, any>
    ): any

    // Re-render a component
    clone<T extends object = any>(
        component: T,
        newEl: HTMLElement
    ): T

    // Version
    version: string

    // Internal (keep loose)
    [key: string]: any
}

export {}
