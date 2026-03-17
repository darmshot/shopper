import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import {viteStaticCopy} from 'vite-plugin-static-copy'
import path from 'path';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/design.ts',
                'resources/css/design.css',
                'resources/js/design/components/widget/product-toolbar.ts',
                'resources/js/design/components/widget/product-toolbar/sort.ts',
                'resources/js/design/components/widget/product-toolbar/variant-filter.ts',
                'resources/js/design/components/widget/product-toolbar/brand-filter.ts',
                'resources/js/design/components/widget/product-toolbar/feature-filter.ts',
                'resources/js/design/components/entity/product/price.ts',
                'resources/js/design/components/entity/product/detail.ts',

                'resources/js/admin.ts',
                'resources/css/admin.css',
                'resources/js/admin/components/widget/products.ts',
                'resources/js/admin/components/widget/categories.ts',
                'resources/js/admin/components/widget/brands.ts',
                'resources/js/admin/components/widget/features.ts',
                'resources/js/admin/components/fx/action/active.ts',
                'resources/js/admin/components/fx/action/featured.ts',
                'resources/js/admin/components/fx/action/duplicate.ts',
                'resources/js/admin/components/fx/action/delete.ts',
                'resources/js/admin/components/fx/action/in-filter.ts',
                'resources/js/admin/components/fx/bulk-action/active.ts',
                'resources/js/admin/components/fx/bulk-action/featured.ts',
                'resources/js/admin/components/fx/bulk-action/duplicate.ts',
                'resources/js/admin/components/fx/bulk-action/delete.ts',
                'resources/js/admin/components/fx/bulk-action/in-filter.ts',
                'resources/js/admin/components/fx/editable/text.ts',
                'resources/js/admin/components/fx/field/editor.ts',
                'resources/js/admin/components/fx/field/dropzone.ts',
                'resources/css/admin/components/fx/field/dropzone.css',
                'resources/js/admin/components/fx/toast.ts',
                'resources/js/admin/components/fx/modal-dialog.ts',
            ],
            refresh: true,
        }),
        tailwindcss(),
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/hugerte/{icons,models,plugins,skins,themes}',
                    dest: './vendor/hugerte',
                },
            ]
        })
    ],
    resolve: {
        alias: {
            design: path.resolve(__dirname, 'resources/js/design'),
            admin: path.resolve(__dirname, 'resources/js/admin'),
        },
    },
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
