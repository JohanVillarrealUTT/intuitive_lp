const mix = require('laravel-mix')

mix.webpackConfig({
  resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/')
        }
    }
})

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

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');
mix.js('resources/js/admin.js', 'public/js/admin.js')
	.js('resources/js/login.js', 'public/js/login.js')
	.js('resources/js/website.js', 'public/js/website.js')
   // .sass('resources/sass/app.scss', 'public/css');
