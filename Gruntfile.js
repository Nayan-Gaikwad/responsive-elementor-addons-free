module.exports = function( grunt ) {
	'use strict';

	const fs = require( 'fs' ),
		pkgInfo = grunt.file.readJSON( 'package.json' );

	require( 'load-grunt-tasks' )( grunt );

	// Project configuration
	grunt.initConfig( {
		pkg: pkgInfo,

		banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
				'<%= grunt.template.today("dd-mm-yyyy") %> */',

		checktextdomain: require( './.grunt-config/checktextdomain' ),
		sass: require( './.grunt-config/sass' ),
		postcss: require( './.grunt-config/postcss' ),
		watch: require( './.grunt-config/watch' ),
		bumpup: require( './.grunt-config/bumpup' ),
		replace: require( './.grunt-config/replace' ),
		release: require( './.grunt-config/release' ),
		copy: require( './.grunt-config/copy' ),
		clean: require( './.grunt-config/clean' ),
		webpack: require( './.grunt-config/webpack' ),
		karma: require( './.grunt-config/karma' ),
		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			},
		},
		compress: {
			build: {
				options: {
					mode: 'zip',
					archive: './build/<%= pkg.name %>.zip'
				},
				expand: true,
				cwd: 'build/<%= pkg.version %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>'
			}
		},
	} );

	// Default task(s).
	grunt.registerTask( 'default', [
		'i18n',
		'scripts',
		'styles',
	] );

	grunt.registerTask( 'i18n', [
		'checktextdomain',
	] );

	grunt.registerTask( 'scripts', ( isDevMode = false ) => {
		let taskName = 'webpack:production';
		if ( isDevMode ) {
			taskName = 'webpack:development';
		}
		grunt.task.run( taskName );
	} );

	grunt.registerTask( 'watch_scripts', () => {
		grunt.task.run( 'webpack:development' );
	} );

	grunt.registerTask( 'styles', ( isDevMode = false ) => {
		grunt.task.run( 'sass' );
		if ( ! isDevMode ) {
			grunt.task.run( 'postcss' );
		}
	} );

	grunt.registerTask( 'watch_styles', () => {
		grunt.task.run( 'watch:styles' );
	} );

	grunt.registerTask( 'build', [
		'default',
		'clean',
		'copy',
		'compress',
	] );

	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );

	grunt.registerTask( 'readme', ['wp_readme_to_markdown'] );

	grunt.registerTask( 'qunit', [
		'karma:unit',
	] );

};