const { src, dest, series, parallel, watch: gulpWatch } = require("gulp");
const gulp = require("gulp");
const browserSync = require("browser-sync").create();
const sass = require("gulp-sass")(require("sass"));
const webpackStream = require("webpack-stream");
const webpack = require("webpack");
const webpackConfig = require("./webpack.config");
const imageResize = require("gulp-image-resize");

function scssTask() {
  return gulp
    .src("./src/scss/style.scss")
    .pipe(sass({ outputStyle: "expanded" }).on("error", sass.logError))
    .pipe(gulp.dest("./dist/main/css/"))
    .pipe(browserSync.stream());
}

function phpTask() {
  return gulp
    .src("./src/*.php")
    .pipe(gulp.dest("./dist/main/"))
    .pipe(browserSync.stream());
}

function jsTask() {
  return gulp
    .src("./src/js/*.js")
    .pipe(webpackStream(webpackConfig, webpack))
    .pipe(gulp.dest("./"))
    .pipe(browserSync.reload({ stream: true }));
}

function sync(done) {
  browserSync.init({
    proxy: "http://localhost:8000",
    snippetOptions: {
      ignorePaths: ["/wp-admin/**", "/wp-login.php"],
    },
  });
  done();
}

function reload(done) {
  browserSync.reload();
  done();
}

function watch(done) {
  gulp.watch("./src/scss/style.scss", scssTask);
  gulp.watch("./src/*.php", phpTask);
  gulp.watch("./src/js/*.js", jsTask);
  done();
}

function resize(done) {
  src("./src/img/**")
    .pipe(
      imageResize({
        crop: true, // リサイズ後に画像をトリミングするかどうか
        upscale: false, // リサイズ後に画像を拡大するかどうか
      })
    )
    .pipe(dest("./dist/main/img/"));

  done();
}

const dev = series(sync, parallel(watch, resize));

exports.default = dev;
