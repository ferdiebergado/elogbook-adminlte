let mix = require('laravel-mix');

const JavaScriptObfuscator = require('webpack-obfuscator');

mix.webpackConfig({
	plugins: [
        	// new JavaScriptObfuscator ({rotateUnicodeArray: true})
        	]
        });

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix	.copy('node_modules/admin-lte/dist/img/boxed-bg.jpg', 'public/img')
	// .copy('node_modules/admin-lte/dist/img/boxed-bg.jpg', 'node_modules/admin-lte/dist/css')
mix .js('resources/assets/js/app.js', 'public/js')
 	.sass('resources/assets/sass/app.scss', 'public/css')
 	.scripts([
	 	'resources/assets/jquery-datatable/jquery.dataTables.js',
	 	'resources/assets/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
	 	'resources/assets/jquery-datatable/extensions/export/dataTables.buttons.min.js',
	 	'resources/assets/jquery-datatable/extensions/export/buttons.flash.min.js',
	 	'resources/assets/jquery-datatable/extensions/export/jszip.min.js',
	 	'resources/assets/jquery-datatable/extensions/export/pdfmake.min.js',
	 	'resources/assets/jquery-datatable/extensions/export/vfs_fonts.js',
	 	'resources/assets/jquery-datatable/extensions/export/buttons.html5.min.js',
	 	'resources/assets/jquery-datatable/extensions/export/buttons.print.min.js',
	 	'node_modules/jquery-highlight/jquery.highlight.js',
	 	'resources/assets/jquery-datatable/extensions/dataTables.searchHighlight.js',
	 	'resources/assets/jquery-datatable/extensions/datatable.ellipsis.js'    
 	],
 	'public/js/plugins.js');
 
if (mix.inProduction()) {
 	mix.version();
}