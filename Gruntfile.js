module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'css/app.css': 'scss/app.scss'
        }
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      }
    },

    cssmin: {
      target: {
        files: {
          'css/app.min.css': ['bower_components/fontawesome/css/font-awesome.min.css', 'css/app.css']
        }
      }
    },

    uglify: {
      target: {
        files: {
          'js/app.min.js': [
            'bower_components/modernizr/modernizr.js',
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/foundation/js/foundation.min.js',
            'vendor/stupidtable.min.js',
            'js/app.js'
          ]
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('build', ['sass', 'cssmin', 'uglify']);
  grunt.registerTask('default', ['build','watch']);
}
