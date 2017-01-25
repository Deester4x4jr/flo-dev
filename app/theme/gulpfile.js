/*

REQUIRED STUFF
==============
*/

var changed     = require('gulp-changed');
var gulp        = require('gulp');
var sass        = require('gulp-sass');
var sourcemaps  = require('gulp-sourcemaps');
var reload      = require('gulp-livereload');
var notify      = require('gulp-notify');
var prefix      = require('gulp-autoprefixer');
var minifycss   = require('gulp-clean-css');
var uglify      = require('gulp-uglify');
var concat      = require('gulp-concat');
var util        = require('gulp-util');
var header      = require('gulp-header');
var pixrem      = require('gulp-pixrem');
var exec        = require('child_process').exec;

/*

FILE PATHS
==========
*/

var sassSrc = 'sass/**/*.{sass,scss}';
var sassFile = 'sass/base/global.scss';
var cssDest = 'css';
var customjs = 'js/scripts.js';
var jsSrc = 'js/src/**/*.js';
var phpSrc = '**/*.php';
var jsDest = 'js';

/*

ERROR HANDLING
==============
*/

var handleError = function(task) {
  return function(err) {

      notify.onError({
        message: task + ' failed, check the logs..'
      })(err);

    util.log(util.colors.bgRed(task + ' error:'), util.colors.red(err));
  };
};

/*

STYLES
======
*/

gulp.task('php', function() {

  reload.reload();

});

/*

STYLES
======
*/

gulp.task('styles', function() {

  gulp.src(sassFile)

    .pipe(sass({
      compass: false,
      bundleExec: true,
      sourcemap: false,
      style: 'compressed',
      debugInfo: true,
      lineNumbers: true,
      errLogToConsole: true,
      includePaths: [
        'bower_components/',
        'node_modules/',
        // require('node-bourbon').includePaths
      ],
    }))

    .on('error', handleError('styles'))
    .pipe(prefix('last 3 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4')) // Adds browser prefixes (eg. -webkit, -moz, etc.)
    .pipe(pixrem())
    .pipe(minifycss({
      advanced: true,
      keepBreaks: false,
      keepSpecialComments: 0,
      mediaMerging: true,
      sourceMap: true
    }))
    .pipe(gulp.dest(cssDest))
    // .pipe(browserSync.stream());
    .pipe(reload());

});

/*

SCRIPTS
=======
*/

gulp.task('js', function() {

      gulp.src(
        [
          'js/src/skip-link-focus-fix.js',
          'js/src/responsive-nav.custom.js',
          'js/src/scripts.js'
        ])
        .pipe(concat('all.js'))
        .pipe(uglify({preserveComments: false, compress: true, mangle: true}).on('error',function(e){console.log('\x07',e.message);return this.end();}))
        .pipe(gulp.dest(jsDest))
        .pipe(reload());
});

/*

WATCH
=====

*/

reload.listen();

// Run the JS task followed by a reload

// gulp.task('js-watch', ['js'], browserSync.reload);
// gulp.task('watch', ['browsersync'], function() {
//
//   gulp.watch(sassSrc, ['styles']);
//   gulp.watch(jsSrc, ['js-watch']);
//
// });

gulp.task('default', function() {

  gulp.watch(sassSrc, ['styles']);
  gulp.watch(jsSrc, ['js']);
  gulp.watch(phpSrc, ['php']);

});
