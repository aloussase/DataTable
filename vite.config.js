import path from "path";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

export default defineConfig({
    css: {
        postcss: {
            plugins: [tailwindcss(), autoprefixer()],
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
});
