/*Seccion 1*/
// Importando los módulos y paquetes requeridos
import fs from 'fs';
import path from 'path';
import { glob } from 'glob';
import { src, dest, watch, series } from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import terser from 'gulp-terser';
import sharp from 'sharp';

/*Seccion 2*/
// Inicializando gulp-sass con dart-sass
const sass = gulpSass(dartSass);

/*Seccion 3*/
// Función para recortar imágenes a un tamaño especificado
export async function crop(done) {
    const inputFolder = 'src/img/gallery';
    const outputFolder = 'src/img/gallery/images-resu-pequeñas';
    const width = 250;
    const height = 180;
    if (!fs.existsSync(outputFolder)) {
        fs.mkdirSync(outputFolder, { recursive: true });
    }
    const images = fs.readdirSync(inputFolder).filter(file => {
        return /\.(jpg)$/i.test(path.extname(file));
    });
    try {
        images.forEach(file => {
            const inputFile = path.join(inputFolder, file);
            const outputFile = path.join(outputFolder, file);
            sharp(inputFile)
                .resize(width, height, {
                    position: 'centre'
                })
                .toFile(outputFile);
        });

        done();
    } catch (error) {
        console.log(error);
    }
}

/*Seccion 4*/
// Función para procesar imágenes y copiarlas al directorio de construcción
export async function imagenes(done) {
    const srcDir = './src/img';
    const buildDir = './build/img';
    const images = await glob('./src/img/**/*{jpg,png}');

    images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        procesarImagenes(file, outputSubDir);
    });
    done();
}

/*Seccion 5*/
// Función auxiliar para procesar imágenes individuales
function procesarImagenes(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true });
    }
    const baseName = path.basename(file, path.extname(file));
    const extName = path.extname(file);
    const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
    const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`);

    const options = { quality: 80 };
    sharp(file).jpeg(options).toFile(outputFile);
    sharp(file).webp(options).toFile(outputFileWebp);
}

/*Seccion 6*/
// Función para compilar SCSS a CSS
export function css(done) {
    src('src/scss/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(dest('build/css'));
    done();
}

/*Seccion 7*/
// Función para minificar archivos JavaScript
export function js(done) {
    src('src/JS/app.js')
        .pipe(terser())
        .pipe(dest('build/js'));
    done();
}

/*Seccion 8*/
// Función para observar cambios en archivos y activar tareas correspondientes
export function dev() {
    watch('src/scss/**/*.scss', css);
    watch('src/JS/**/*.js', js);
    watch('src/IMG/**/*.{jpg,png}', imagenes);
}

/*Seccion 9*/
// Tarea por defecto que se ejecuta cuando se ejecuta 'gulp' 'npm run dev'
export default series(crop, css, js, imagenes, dev); /*No tocar, cambios dentro del Json*/
