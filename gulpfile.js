import pkg from "gulp";
const { src, dest, watch, series, parallel } = pkg;
// css
import dartSass from "sass";
import gulpSass from "gulp-sass";
const sass = gulpSass(dartSass);
import autoprefixer from "autoprefixer";
import cssnano from "cssnano";
import postcss from "gulp-postcss";
import sourcemaps from "gulp-sourcemaps";
// imagenes
import webp from "gulp-webp";
import imagemin from "gulp-imagemin";
import cache from "gulp-cache";
import avif from "gulp-avif";

// javascript
import terser from "gulp-terser-js";
// implementos
import "gulp-concat";
import "gulp-rename";
import notify from "gulp-notify";
import "gulp-clean";

const paths = {
    scss: "src/scss/**/*.scss",
    js: "src/js/**/*.js",
    imagenes: "src/img/**/*.{jpg,jpeg,png,ico,svg}",
};
// css
const css = () => {
    return src(paths.scss) // identificar el archivo sass
        .pipe(sourcemaps.init())
        .pipe(sass()) // compilarlo
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write("."))
        .pipe(dest("public/build/css")); // almacenar en el disco duro
};
// javascript
const javascript = () => {
    return src(paths.js)
        .pipe(terser())
        .pipe(sourcemaps.write("."))
        .pipe(dest("public/build/js"));
};

// convierte a webp
const versionWebp = () => {
    const opciones = {
        quality: 50,
    };
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest("public/build/img"))
        .pipe(notify({ message: "Imagen completada" }));
};
const versionAvif = () => {
    const opciones = {
        quality: 50,
    };
    return src(paths.imagenes)
        .pipe(avif(opciones))
        .pipe(dest("public/build/img"));
};
// minifica el peso de las imagenes
const imagenes = () => {
    const opciones = {
        optimizationLevel: 3,
    };
    return src(paths.imagenes)
        .pipe(cache(imagemin(opciones)))
        .pipe(dest("public/build/img"))
        .pipe(notify({ message: "Imagen completada" }));
};

const watchArchivos = () => {
    watch(paths.scss, css);
    watch(paths.js, javascript);
    watch(paths.imagenes, imagenes);
    watch(paths.imagenes, versionWebp);
};
export { css, watchArchivos };
export default parallel(
    css,
    javascript,
    imagenes,
    versionWebp,
    versionAvif,
    watchArchivos
);
