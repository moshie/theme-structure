var gulp            = require('gulp'),
    compass         = require('gulp-compass'),
    uglify          = require('gulp-uglify'),
    notify          = require("gulp-notify"),
    minifycss       = require('gulp-minify-css'),
    autoprefixer    = require('gulp-minify-css');


var paths = {
    sass: 'resources/styles/scss',
    css: 'resources/styles/css',
    images: 'resources/styles/images',
    js: 'resources/scripts/javascript',
    jsmin: 'resources/scripts/javascript/minified'
};

gulp.task('styles', function() {
    return gulp.src([paths.sass + '/**/*.scss'])
        .pipe(compass({
            css: paths.css,
            sass: paths.sass,
            image: paths.images
        }))
        .pipe(autoprefixer())
        .pipe(gulp.dest(paths.css))
        .pipe(minifycss())
        .pipe(gulp.dest('./'))
        .pipe(notify('Styles have been compiled'));
});

gulp.task('scripts', function() {
    return gulp.src(paths.js + '/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest(paths.jsmin))
        .pipe(notify('scripts have been compiled'));
});

gulp.task('stylesDev', function() {
    return gulp.src([paths.sass + '/**/*.scss'])
        .pipe(compass({
            css: paths.css,
            sass: paths.sass,
            image: paths.images
        }))
        .pipe(autoprefixer())
        .pipe(gulp.dest(paths.css))
        .pipe(notify('Styles have been compiled'));
});

gulp.task('default', function() {
    gulp.watch('resources/styles/scss/**/*.scss', ['styles']);
    gulp.watch('resources/scripts/javascripts/**/*.scss', ['scripts']);
});

gulp.task('dev', function() {
    gulp.watch('resources/styles/scss/**/*.scss', ['stylesDev']);
});

gulp.task('deploy', ['styles', 'scripts']);