import svelte from 'rollup-plugin-svelte';
import uglify from 'rollup-plugin-uglify';

export default {
    entry: 'src/js/main.js',
    dest: 'dist/js/main.min.js',
    format: 'iife',
    plugins: [
        svelte(),
        uglify()
    ]
};
