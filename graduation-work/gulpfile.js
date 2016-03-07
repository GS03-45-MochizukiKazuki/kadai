var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var sass = require('gulp-sass');
var cssnext = require('gulp-cssnext');

var paths = {
  'scss': './src/sass/',
  'css': './public/css/',
  'img': './src/img/'
};

// css
gulp.task('sass', function () {
  return gulp.src( paths.scss + '**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(cssnext())
    .pipe(gulp.dest( paths.css ));
});
gulp.task('sass:watch', function () {
  gulp.watch( paths.scss + '**/*.scss', ['sass']);
});

// image
gulp.task("imagemin", function() {
    gulp.src( paths.img + "*.{png,jpg,gif}")
        .pipe(imagemin({
        	progressive: true,
			use: [pngquant({quality: '65-80', speed: 1})]
        }))
        .pipe(gulp.dest('./public/img/'));
});

gulp.task('default', ['sass:watch', 'imagemin']);