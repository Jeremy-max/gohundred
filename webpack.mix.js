const mix = require('laravel-mix');
let LiveReloadPlugin = require('webpack-livereload-plugin');

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

mix.webpackConfig({
  plugins: [
      new LiveReloadPlugin()
  ]
});


const theme = {
  sourceCss: [
    'resources/dist/vendors/global/vendors.bundle.css',
    'resources/dist/css/demo1/style.bundle.css',
    'resources/dist/css/demo1/skins/header/base/light.css',
    'resources/dist/css/demo1/skins/header/menu/light.css',
    'resources/dist/css/demo1/skins/brand/dark.css',
    'resources/dist/css/demo1/skins/aside/dark.css',
    'resources/custom/dashboard/signup.css'
  ],
  destCss: [
    'public/vendors/global/vendors.bundle.css',
    'public/css/style.bundle.css',
    'public/css/skins/header/base/light.css',
    'public/css/skins/header/menu/light.css',
    'public/css/skins/brand/dark.css',
    'public/css/skins/aside/light.css',
    'public/css/signup.css'
  ],
  sourceFont: [
    'resources/dist/vendors/global/fonts',
  ],
  destFont: [
    'public/css/fonts',
  ],
  sourceJs: [
    'resources/dist/vendors/global/vendors.bundle.js',
    'resources/dist/js/demo1/scripts.bundle.js'
  ],
  destJs: [
    'public/vendors/global/vendors.bundle.js',
    'public/js/scripts.bundle.js'
  ]
}

const custom = {
  dashboard: {
    sourceCss: [
      'resources/custom/dashboard/custom.css'
    ],
    destCss:[
      'public/css/dashboard/custom.css'
    ],
    sourceJs: [
      // 'resources/custom/dashboard/index.js',
       'resources/custom/dashboard/stock-charts.js',
//      'resources/custom/dashboard/json-datatable.js',
//      'resources/custom/dashboard/bootstrap-select-country.js',
      'resources/custom/dashboard/search_table.js',
      'resources/custom/dashboard/customdashboard.js',

      //      'resources/custom/dashboard/amcharts.js'
    ]
  }
}

mix.copy(theme.sourceCss[0], theme.destCss[0])
  .copy(theme.sourceCss[1], theme.destCss[1])
  .copy(theme.sourceCss[2], theme.destCss[2])
  .copy(theme.sourceCss[3], theme.destCss[3])
  .copy(theme.sourceCss[4], theme.destCss[4])
  .copy(theme.sourceCss[5], theme.destCss[5])
  .copy(theme.sourceJs[0], theme.destJs[0])
  .copy(theme.sourceJs[1], theme.destJs[1])
  .copyDirectory(theme.sourceFont[0], theme.destFont[0])
  .styles(theme.destCss, 'public/css/theme.css')
  .scripts(theme.destJs, 'public/js/theme.js')
  // custom
  .scripts(custom.dashboard.sourceJs, 'resources/custom/dashboard/dashboard.js')
  .copy('resources/custom/dashboard/dashboard.js', 'public/js/dashboard/dashboard.js')
  .copy('resources/custom/dashboard/admindashboard.js', 'public/js/dashboard/admindashboard.js')
  .copy('resources/custom/dashboard/global.js', 'public/js/dashboard/global.js')
  .copy('resources/custom/dashboard/main.css', 'public/css/dashboard/main.css')
  .copy(custom.dashboard.sourceCss[0], custom.dashboard.destCss[0])
