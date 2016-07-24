'use strict';

// DEPENDENCIES
var gulp   = require('gulp' ),
    sass   = require('gulp-sass' ),
    concat = require('gulp-concat' ),
    rename = require('gulp-rename' ),
    uglify = require('gulp-uglify');

// BASIC PATH INFORMATION
var jsFiles     = './assets/js/core/core.js',
    jsDest      = './assets/static/js',
    scssFiles   = './assets/scss/',
    scssDest    = './assets/static/css',
    sassOptions = { outputStyle: 'compressed', includePaths: require('node-bourbon').includePaths };

// DETAILED TASKS
gulp.task( 'coreSass', function () {
  return gulp.src( scssFiles + 'core.scss' ).pipe( sass( sassOptions ).on( 'error', sass.logError ) ).pipe( gulp.dest( scssDest ) )
});

gulp.task( 'themeSass', function () {
  return gulp.src( scssFiles + 'theme-style.scss' ).pipe( sass( sassOptions ).on( 'error', sass.logError ) ).pipe( gulp.dest( scssDest ) )
});

// ADMIN SASS COMPILATION, DISABLED BY DEFAULT, AS NOT NEEDED IN THEME, NORMALLY
//gulp.task( 'adminSass', function () {
//  return gulp.src( scssFiles + 'admin-style.scss' ).pipe( sass( sassOptions ).on( 'error', sass.logError ) ).pipe( gulp.dest( scssDest ) );
//});

gulp.task( 'scripts', function() {
  return gulp.src(jsFiles)
    .pipe( concat( '*.js') )
    .pipe( uglify() )
    .pipe( rename('core.js') )
    .pipe( gulp.dest( jsDest ) );
});

// WATCH FOR CHANGES AND RUN BUNDLED TASKS
gulp.task( 'watch', function () {
  gulp.watch( './assets/scss/*.scss', ['sass'] );
  gulp.watch( './assets/js/*.js', ['scripts'] );
});

// BUNDLED TASKS
gulp.task( 'sass', ['coreSass','themeSass'] );
gulp.task( 'compile', ['coreSass', 'themeSass', 'scripts'] );
