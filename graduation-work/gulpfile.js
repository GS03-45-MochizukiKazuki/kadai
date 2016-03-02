var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var sass = require('gulp-sass');

// css
gulp.task('sass', function () {
  return gulp.src('./src/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public/css'));
});
gulp.task('sass:watch', function () {
  gulp.watch('./src/sass/**/*.scss', ['sass']);
});

// image
gulp.task("imagemin", function() {
    gulp.watch("./src/img/*.{png,jpg,gif}", function() {   
        gulp.src("./src/img/*.{png,jpg,gif}")
            .pipe(imagemin({
            	progressive: true,
    			use: [pngquant({quality: '65-80', speed: 1})]
            }))
            .pipe(gulp.dest('./public/img/'));
    });
});

gulp.task('default', ['sass:watch', 'imagemin']);