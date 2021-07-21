/*
var gulp = require('gulp');
console.log(gulp);

gulp.task('default', [], function(done) {
  console.log("Moving all files in styles folder");
  gulp.src("node_modules/jquery/dist/jquery.js")
    .pipe(gulp.dest('public/js/dist'));
});

exports.default = gulp.series('default');
*/

const { src, dest } = require('gulp');

exports.default = function() {
  return src("node_modules/jquery/dist/jquery.js")
    .pipe(src("node_modules/bootstrap/dist/css/bootstrap.css"))
    .pipe(src("node_modules/bootstrap/dist/js/bootstrap.js"))
    .pipe(src("node_modules/jquery-datetimepicker/jquery.datetimepicker.css"))
    .pipe(src("node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.js"))
    .pipe(dest('public/js/dist'));
}