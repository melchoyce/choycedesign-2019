var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var livereload = require('gulp-livereload');

const css = function() {
	var processors = [autoprefixer({ browsers: ['last 2 versions'] })];
	return gulp
		.src('./scss/style.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(gulp.dest('.'))
		.pipe(livereload());
};

gulp.task('css', css);

gulp.task('default', function() {
	livereload.listen();
	gulp.watch('scss/**/*.scss', css);
});
