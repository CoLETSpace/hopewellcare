var gulp = require('gulp'),
    autoprefixer = require('autoprefixer'),
    plumber = require( 'gulp-plumber' ),
    watch = require( 'gulp-watch' ),
    livereload = require( 'gulp-livereload' ),
    minifycss = require( 'gulp-cssnano' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    notify = require( 'gulp-notify' ),
    include = require( 'gulp-include' ),
    sass = require( 'gulp-sass' ),
    concat = require('gulp-concat'),
    postcss = require('gulp-postcss'),
    mqpacker = require('css-mqpacker'),
    imagemin = require('gulp-imagemin'),
    sprity = require('sprity'),
    gulpif = require('gulp-if'),
    sourcemaps = require('gulp-sourcemaps'),
    wpPot = require('gulp-wp-pot');

var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

var src = './assets/';
var dest = './dist/';

var paths = {
    /* Source paths */
    styles: src + 'styles/**/*.scss',
    scripts: src + 'scripts/',
    images: src + 'images/**/*',
    sprites: src + 'images/sprites/',
    fonts: src + 'fonts/*',
    libs: src + 'vendor/**/*',

    /* Output paths */
    stylesOutput: dest + 'styles/',
    scriptsOutput: dest + 'scripts/',
    imagesOutput: dest + 'images/',
    spritesOutput: dest + 'images/sprites/',
    fontsOutput: dest + 'fonts/',
    libsOutput: dest + 'vendor/',
};


gulp.task( 'styles', function() {
    return gulp.src( paths.styles, {
        style: 'expanded'
    } )
    .pipe( plumber( { errorHandler: onError } ) )
    .pipe( sass() )
    .pipe( gulp.dest( './' ) )
    .pipe(postcss([
        autoprefixer({
            browsers: ['last 2 version']
        }),
        mqpacker({
            sort: true
        }),
    ]))
    .pipe(sourcemaps.init())
    .pipe( minifycss() )
    .pipe(sourcemaps.write())
    .pipe( rename( { suffix: '.min' } ) )
    .pipe( gulp.dest( paths.stylesOutput ) )
    .pipe( notify( { message: 'Styles task complete' } ) );
});

gulp.task('scripts', function(){
  var basePath = paths.scripts;
  var files = ['app.js', 'navigation.js', 'skip-link-focus.js'];
  var scripts = files.map(f => basePath + f);
  return gulp.src(scripts)
      .pipe(concat('main.js'))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(paths.scriptsOutput))
      .pipe( notify( { message: 'Script task complete' } ) );
});

gulp.task('images', function(){
  return gulp.src(paths.images)
    .pipe(imagemin({
        optimizationLevel: 5,
        progressive: true,
        interlaced: true
    }))
    .pipe(gulp.dest(paths.imagesOutput))
    .pipe( notify( { message: 'Images task complete' } ) );
});

gulp.task('sprites', function () {
  return sprity.src({
    src: paths.sprites + '*.{jpg,png}',
    split: true,
    processor: 'scss', // make sure you have installed sprity-sass 
  })
  .pipe(gulpif('*.png', gulp.dest(paths.spritesOutput), gulp.dest('./assets/styles/components')))
});


gulp.task('fonts', function(){
  return gulp.src(paths.fonts)
    .pipe(gulp.dest(paths.fontsOutput))
    .pipe( notify( { message: 'Fonts task complete' } ) );
});

gulp.task('libs', function() {
    return gulp.src(paths.libs)
        .pipe(gulp.dest(paths.libsOutput))
        .pipe( notify( { message: 'Libs task complete' } ) );
});

gulp.task( 'watch', function() {
    livereload.listen();
    gulp.watch( paths.styles, [ 'styles' ] );
    gulp.watch( paths.scripts, [ 'scripts' ] );
    gulp.watch( paths.images, [ 'images' ] );
    gulp.watch( paths.fonts, [ 'fonts' ] );
    gulp.watch( paths.sprites, [ 'sprites' ] );
    gulp.watch( paths.libs, [ 'libs' ] );
} );

gulp.task( 'default', [ 'watch', 'styles', 'scripts', 'images', 'fonts', 'libs'], function() {});
