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
          'css/app.css': 'web/scss/app.scss'
        }
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'web/scss/**/*.scss',
        tasks: ['sass']
      }
    },

    cssmin: {
      target: {
        files: {
          'web/css/app.min.css': ['web/css/app.css']
        }
      }
    },

    uglify: {
      target: {
        files: {
          'web/js/app.min.js': [
            'bower_components/modernizr/modernizr.js',
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/foundation/js/foundation.min.js',
            'web/js/vendor/stupidtable.min.js',
            'web/js/app.js'
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
