
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import * as glob from 'glob';
import path from 'path';

const scssFiles = glob.sync('resources/assets/scss/**/*.scss');
const jsFiles = glob.sync('resources/assets/js/**/*.js');

const cleanInputName = (file, type) => {
    console.log(`${path.parse(file).name}`)
    console.log(type)
    const relative = `${path.parse(file).name}`;
    return type === 'scss' ? `${relative}.css` : relative;
};

const inputs = [...scssFiles, ...jsFiles].reduce((acc, file) => {
    const isScss = file.endsWith('.scss');
    const type = isScss ? 'scss' : 'js';
    const name = cleanInputName(file, type);
    acc[name] = path.resolve(__dirname, file);
    return acc;
}, {});

export default defineConfig({
    plugins: [
        laravel({
            input: Object.values(inputs),
            refresh: false,
        }),
    ],
    build: {
        outDir: 'public',
        manifest: false,
        emptyOutDir: false,
        minify: true,
        rollupOptions: {
            input: inputs,
            output: {
                assetFileNames: (info) => {
                    if (info.name.endsWith('.css')) {
                        return 'css/[name].min.css';
                    }
                    return 'js/[name].min.js';
                },
                entryFileNames: 'js/[name].min.js',
                chunkFileNames: 'js/[name].min.js',
            },
        },
    },
});

