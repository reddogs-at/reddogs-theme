module.exports = function(grunt) {
	'use strict';
	grunt.util.linefeed = '\n';
	var globalConfig = grunt.file.readJSON('./reddogs/config/config.json');
	var configBridge = grunt.file.readJSON('./bower_components/bootstrap/grunt/configBridge.json', { encoding: 'utf8' });
	grunt.initConfig({
		globalConfig : globalConfig,
		watch : {
			less : {
				files : ['reddogs/less/*.less'],
				tasks : ['less', 'autoprefixer', 'cssmin']
			},
			concat: {
				files: 'reddogs/js-src/*.js',
				tasks: ['concat:reddogs', 'uglify:reddogs']
			},
		},
		less : {
			compileTheme : {
				options : {
					strictMath : true,
					sourceMap : true,
					outputSourceFiles : true,
					sourceMapURL : 'reddogs.css.map',
					sourceMapFilename : 'reddogs/css/reddogs.css.map'
				},
				files : {
					'reddogs/css/reddogs.css' : 'reddogs/less/reddogs.less',
				}
			},
		},
		autoprefixer : {
			options: {
				browsers: configBridge.config.autoprefixerBrowsers
			},
			theme: {
				options: {
					map: true
				},
				src: 'reddogs/css/reddogs.css'
			},
		},
	    cssmin: {
	        options: {
	          compatibility: 'ie8',
	          keepSpecialComments: '*',
	          noAdvanced: true
	        },
	        minifyTheme: {
	          src: 'reddogs/css/reddogs.css',
	          dest: 'reddogs/css/reddogs.<%= globalConfig.versions.css  %>.min.css'
	        },
	      },
	concat: {
		reddogs: {
			src: [
			      'bower_components/bootstrap/js/transition.js',
			      'bower_components/bootstrap/js/alert.js',
			      'bower_components/bootstrap/js/button.js',
			      'bower_components/bootstrap/js/collapse.js',
			      'bower_components/bootstrap/js/dropdown.js',
			      'bower_components/bootstrap/js/modal.js',
			      'bower_components/bootstrap/js/tooltip.js',
			      'bower_components/bootstrap/js/popover.js',
			      'bower_components/bootstrap/js/scrollspy.js',
			      'bower_components/bootstrap/js/tab.js',
			      'bower_components/bootstrap/js/affix.js',
			      'reddogs/js-src/*.js',
			      ],
			      dest: 'reddogs/js/reddogs.js'
			}
		},
		uglify: {
	    	reddogs: {
	    		src: 'reddogs/js/reddogs.js',
	            dest: 'reddogs/js/reddogs.<%= globalConfig.versions.js %>.min.js'
	    	},
	    }
	});
	require('load-grunt-tasks')(grunt, {
		scope : 'devDependencies',
		config : './bower_components/bootstrap/package.json'
	});
}