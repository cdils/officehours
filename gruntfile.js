/**
 * Grunt Module
 */
module.exports = function(grunt) {
	/**
	 * Load Grunt plugins
	 */
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);
	/**
	 * Configuration
	 */
	grunt.initConfig({
		/**
		 * Get package meta data
		 */
		pkg: grunt.file.readJSON('package.json'),
		/**
		* Bower Copy
		*/
		bowercopy: {
			options: {
				srcPrefix: 'bower_components',
				clean: true
			},
			scss: {
				options: {
					destPrefix: 'assets/scss/vendor'
				},
				files: {
					bourbon: 'bourbon/app/assets/stylesheets',
					neat: 'neat/app/assets/stylesheets'
				}
			}
		},
		/**
		 * Sass
		 */
		sass: {
			dist: {
				options: {
					style: 'expanded',
					lineNumbers: false,
					debugInfo: false,
					compass: false
				},
				files: {
					'style.css' : 'assets/scss/style.scss'
				}
			}
		},
		/**
		 * Watch
		 */
		watch: {
			sass: {
				files: [
					'assets/scss/*.scss',
					'assets/scss/**/*.scss',
					'assets/scss/**/**/*.scss'
				],
				tasks: [
					'sass'
				]
			}
		},
		// https://github.com/gruntjs/grunt-contrib-compress
		compress: {
			standard: {
				options: {
					archive: 'dist/<%= pkg.name %>-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						cwd: '',
						src: [ // Take this...
							'**',
							'!gruntfile.js',
							'!package.json',
							'!bower.json',
							'!style.css.map',
							'!assets/**',
							'!node_modules/**',
							'!.sass-cache/**',
							'!dist/**',
							'!*.sublime*',
							'!.DS_Store'
						],
						dest: '<%= pkg.name %>' // ...put it into this, then zip that up as ^^^
					}
				]
			},
			dev: {
				options: {
					archive: 'dist/<%= pkg.name %>-developer-<%= pkg.version %>.zip'
				},
				files: [
					{
						expand: true,
						src: [
							'**',
							'!node_modules/**',
							'!.sass-cache/**',
							'!dist/**',
							'!*.sublime*',
							'!.DS_Store'
						], // Take this...
						dest: '<%= pkg.name %>' // ...put it into this, then zip that up as ^^^
					}
				]
			}
		}

	});

	/**
	 * Default task
	 * Run `grunt` on the command line
	 */
	grunt.registerTask('default', [
		'bowercopy',
		'sass',
		'watch'
	]);
};
