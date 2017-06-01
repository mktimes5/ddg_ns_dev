var gulp = require('gulp');
var $    = require('gulp-load-plugins')();
var babel = require("gulp-babel");
var sassPaths = [
  'bower_components/normalize.scss/sass',
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];
/*
gulp.task('javascript', function() {
  return gulp.src(PATHS.javascript)
    .pipe(babel.sourcemaps.init())
    .pipe(babel.babel()) // <-- There it is!
    .pipe(babel.concat('app.js'))
    .pipe(uglify)
    .pipe(babel.if(!isProduction, $.sourcemaps.write()))
    .pipe(gulp.dest('js/app.js'))
    .on('finish', browser.reload);
});
*/

gulp.task('js', function() {
  return gulp.src('js/build/*.js')
  .pipe(babel())
  .pipe(gulp.dest('js'));
});


gulp.task('sass', function() {
  return gulp.src('scss/app.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('css'));
});

gulp.task('default', ['sass'], function() {
  gulp.watch(['scss/**/*.scss'], ['sass']);
});
