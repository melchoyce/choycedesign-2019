const path = require('path');
const gulp = require('gulp');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const postcssSVG = require('postcss-inline-svg')
const livereload = require('gulp-livereload');

const css = function() {
	var processors = [
		postcssSVG({
			paths: [ path.resolve( './' ) ],
		}),
		autoprefixer(),
	];

	return gulp
		.src('./scss/style.scss')
		.pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
		.pipe(postcss(processors))
		.pipe(gulp.dest('.'))
		.pipe(livereload());
};

gulp.task('css', css);

gulp.task('default', function() {
	livereload.listen();
	gulp.watch('scss/**/*.scss', css);
});
