### Tailwind css config Gulp
1) ejecutar npm run tail para abrir el --watch de tailwind
2)  npm run dev para gul
3)  

#### package json

```json
"scripts": {
        "tail": "npx tailwindcss -i src/sass/index.scss -o ./public/build/css/index.css --watch",
        "dev": "gulp"
    },
    "keywords": [],
    "author": "",
    "license": "ISC",
    "devDependencies": {
        "autoprefixer": "^10.4.8",
        "cssnano": "^5.1.12",
        "gulp": "^4.0.2",
        "gulp-avif": "^1.1.1",
        "gulp-cache": "^1.1.3",
        "gulp-clean": "^0.4.0",
        "gulp-concat": "^2.6.1",
        "gulp-imagemin": "^7.1.0",
        "gulp-notify": "^4.0.0",
        "gulp-plumber": "^1.2.1",
        "gulp-postcss": "^9.0.1",
        "gulp-rename": "^2.0.0",
        "gulp-sass": "^5.1.0",
        "gulp-sourcemaps": "^3.0.0",
        "gulp-terser-js": "^5.2.2",
        "gulp-webp": "^4.0.1",
        "sass": "^1.54.0",
        "tailwindcss": "^3.1.7",
        "terser": "^5.14.2"
    } 
 ```
 gulpfile.js : cambiar path
 
 ```js
 const css = () => {
    return src(paths.tailwindcss) // identificar el archivo sass
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError)) // compilarlo
        .pipe(postcss([tailwindcss, autoprefixer, cssnano]))
        .pipe(sourcemaps.write("."))
        .pipe(dest("public/build/css")); // almacenar en el disco duro
};
 
 ```
 
 ### bootstrap : Copiar y pegar archivo bootrap.min.js en la carpeta js
 
 
 ```scss
 // Changing the theme colors
$primary: #430000;
$secondary: #3ab7ff;
$success: #65ff9f;
$info: #7164ff;
$warning: #ff9f65;
$danger: #ff457b;
$dark: #18181d; 

@import '../bootstrap/scss/bootstrap.scss';

 ```
 ```js
 // css
const css = () => {
    return src(paths.tailwindcss) // identificar el archivo sass
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError)) // compilarlo
        .pipe(postcss([ autoprefixer, cssnano]))
        .pipe(sourcemaps.write("."))
        .pipe(dest("public/build/css")); // almacenar en el disco duro
};
 
 
 
