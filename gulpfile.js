/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var gulp      = require( 'gulp' ),
    minifycss   = require( 'gulp-minify-css' ),
    watch       = require( 'gulp-watch' ),
    uglify      = require( 'gulp-uglify' ),
    sass        = require( 'gulp-sass' ),
    sourcemaps = require('gulp-sourcemaps'),
    plumber     = require( 'gulp-plumber' ),
    browserSync = require( 'browser-sync' ),
    jshint      = require( 'gulp-jshint' ),
    notify      = require('gulp-notify'),
    stylish     = require( 'jshint-stylish' ),
    reload      = browserSync.reload;



var config = {
    bowerDir: './bower_components'
};

// Different options for the Sass tasks
var options = {};
options.scss = {
    errLogToConsole: true,
    precision: 8,
    noCache: true,
    includePaths: [
        config.bowerDir + '/bootstrap-sass/assets/stylesheets',
        config.bowerDir + '/fontawesome/scss'
    ]
};

// We need to set up an error handler (which gulp-plumber calls).
// Otherwise, Gulp will exit if an error occurs, which is what we don't want.
var onError = function( err ) {
    console.log( 'An error occured:', err );
    this.emit( 'end' );
};

gulp.task('fontawesome-fonts', function() {
    return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*')
        .pipe(gulp.dest('./fonts/fontawesome'));
});

gulp.task('bootstrap-fonts', function() {
    return gulp.src(config.bowerDir + '/bootstrap-sass/assets/fonts/bootstrap/**.*')
        .pipe(gulp.dest('./fonts/bootstrap'));
});

// Our development server that serves all the assets and reloads the browser
// when any of them change (hence the watch calls in it)
gulp.task( 'server', function() {
    browserSync.init({
        // change 'playground' to whatever your local Nginx/Apache vhost is set
        // most commonly 'http://localhost/' or 'http://127.0.0.1/'
        // See http://www.browsersync.io/docs/options/ for more information
        proxy: 'http://beta.dev/'
    });
    // Reload the browser if any gulp.php file changes within this directory
    watch( './**/*.php', reload);

    // Recompile sass into CSS whenever we update any of the source files
    watch( './sass/**/*.scss', function() {
        gulp.start( 'scss' );
    });

    // Watch our JavaScript files and report any errors. May ruin your day.
//  watch( './js/**/*.js', function() {
//    gulp.start( 'jshint' );
//  })
});


// Processes SASS and reloads browser.
gulp.task( 'scss', function() {
    return gulp.src( './sass/style.scss' )
        .pipe(sourcemaps.init())
        .pipe( plumber( { errorHandler: onError } ) )
        .pipe( sass(options.scss) )
        .pipe(sourcemaps.write('./sass/maps'))
        .pipe( gulp.dest( '.' ) )
        .pipe(notify({title:'scss',message:'Sass task complete'}))
        .pipe( reload( { stream: true } ) );
} );


// Jshint outputs any kind of javascript problems you might have
// Only checks javascript files inside /js directory
gulp.task( 'jshint', function() {
    return gulp.src( './js/**/*.js' )
        .pipe( jshint( '.jshintrc' ) )
        .pipe( jshint.reporter( stylish ) )
        .pipe( jshint.reporter( 'fail' ) );
});


// The default task. When developing just run 'gulp' and this is what will be ran.
// Note the second parameter, those are dependency tasks which need to be done
// before the main function (third parameter) is called.
gulp.task( 'default', [ 'scss', 'server' ], function() {
    console.log('done');
} );
