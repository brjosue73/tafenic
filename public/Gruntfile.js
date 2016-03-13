'use strict';

module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			sass: {
				files: ['src/scss/framework/*.scss','src/scss/layouts/*.scss','src/scss/*.scss'],
				tasks: ['sass']
			},/*
			cssmin: {
				files: ['/res/css/styles.css'],
				tasks: ['cssmin']
			},*/
			uglify: {
				files: ['src/js/*.js'],
				tasks: ['uglify']
			}
		},
		sass: {
			dist: {
				files: {
					'res/css/styles.css':'src/scss/styles.scss'
				}
			}
		},
		cssmin: {
			myTarget: {
				files: [{
					expand: false,
					src:  ['/res/css/styles.css'],
					dest: '/res/css/styles.min.css'
				}]
			}
		},
		uglify: {
			dist: {
				src:  ['src/js/*.js'],
				dest: 'res/js/scripts.min.js'
			}
		},
		browserSync: {
			dev: {
				bsFiles: {
		        	src: [
						'res/css/styles.css',
						'res/js/scripts.min.js',
						'res/js/angular.js',
						'partials/*.html'
					]
			    },
        	options: {
        			proxy:'<%= php.dev.options.hostname %>:<%= php.dev.options.port %>',
					//port:8000,
					//baseDir:'res',
          			watchTask: true,
        			open: true
				}
			}
		},
		php: {
			dev: {
				options: {
					hostname: '127.0.0.1',
					port: 5000,
					base: '.'
					//open: false,
					//keepalive: true
				}
			}
		},
		imagemin: {
		    dynamic: {
		      files: [{
		        expand: true,
		        cwd: 'src/img/',
		        src: ['**/*.jpg'],
		        dest: '/res/img/'
		      }]
		    }
		}
	});
	grunt.loadNpmTasks('grunt-php');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');

	grunt.registerTask('default',['php','browserSync','watch']);
	grunt.registerTask('build',[ 'imagemin' , 'cssmin']);
}
