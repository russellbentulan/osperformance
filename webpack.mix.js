const mix = require("laravel-mix")
const themeRoot = `web/app/themes/osperformance`
const publicPath = `${themeRoot}/dist`
const resourceRoot = `${themeRoot}/src`

// set the public path directory
mix.setPublicPath(publicPath)

// enable versioning for all compiled files
mix.version()

// set global webpack config
mix.webpackConfig({
  resolve: {
    modules: [`node_modules`],
  },
  module: {
    rules: [
      {
        test: /\.scss/,
        enforce: `pre`,
        loader: `import-glob-loader`,
      },
    ],
  },
})

// initialise the mix compiling
mix
  .babel(
    [
      `${resourceRoot}/scripts/index.js`,
      `${resourceRoot}/scripts/editor.js`,
    ],
    `js/index.js`
  )
  .minify(`${publicPath}/js/index.js`)
  .minify(`${publicPath}/js/editor.js`)
  .sass(`${resourceRoot}/styles/editor.scss`, `css`)
  .sass(`${resourceRoot}/styles/index.scss`, `css`)
  .options({
    processCssUrls: false,
  })
  .browserSync({
    proxy: `http://os-performance.local/`,
    files: [`${themeRoot}/**/*.php}`, `${resourceRoot}/**/*`],
  })
