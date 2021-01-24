const mix = require("laravel-mix")
const pluginRoot = `web/app/plugins/os-blocks`
const publicPath = `${pluginRoot}/dist`
const resourceRoute = `${pluginRoot}/src`

// set the public path directory
mix.setPublicPath(publicPath)

// enable versioning for all compiled files
mix.version()

// set global webpack config
mix.webpackConfig({
  entry: {
    index: `/${resourceRoute}/index.js`
  },
  output: {
    filename: `[name].js`,
    path: path.resolve( process.cwd(), publicPath )
  },
  resolve: {
    modules: [`node_modules`],
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
            loader: 'babel-loader',
            options: {
                presets: [ "@babel/preset-env", "@babel/preset-react" ],
                plugins: [ "@babel/plugin-transform-runtime" ]
            }
        }
      },
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
  .minify(`${publicPath}/index.js`)
  .sass(`${resourceRoute}/editor.scss`, ``)
  .sass(`${resourceRoute}/style.scss`, ``)
  .options({
    processCssUrls: false,
  })
  .browserSync({
    proxy: `http://os-performance.local/`,
    files: [`${resourceRoute}/**/*}, ${resourceRoute}/*}`],
  })
