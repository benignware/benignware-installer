const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const cssf = require('cssf/int/sass');

module.exports = {
  mode: process.env.NODE_ENV || 'development',
  entry: [
    path.resolve(__dirname, 'js/index.js'),
    path.resolve(__dirname, 'scss/index.scss')
  ],
  output: {
    path: path.join(__dirname, 'public'),
    // filename: 'main.js'
  },
  plugins: [new MiniCssExtractPlugin()],
  module: {
    rules: [{
      test: /\.(jpe?g|gif|png|woff(2)?|ttf|eot|otf)(\?[a-z0-9=\.]*)?$/,
      type: 'asset/resource'
    }, {
      test: /\.scss$/,
      use: [
        MiniCssExtractPlugin.loader,
        'css-loader',
        {
          loader: 'sass-loader',
          options: {
            // implementation: scssf,
            sassOptions: {
              includePaths: [
                path.resolve(__dirname, 'node_modules'),
                // path.resolve(__dirname, 'node_modules/bootstrap/scss'),
              ],
              functions: cssf
            }
          }
        }
      ]
    }, {
      test: /\.(woff(2)?|ttf|eot|otf)(\?[a-z0-9=\.]*)?$/,
      type: "asset",
      // loader: 'file-loader',
      // options: {
      //   name: '[path][name].[ext]',
      //   emitFile: true
      // }
    }, /* {
      test: /\.(png|jpg|gif|svg)$/i,
      use: [
        {
          loader: 'url-loader',
          options: {
            limit: 8192,
          },
        },
      ],
    },*/]
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /node_modules/,
          chunks: 'initial',
          name: 'vendor',
          enforce: true
        },
      }
    } 
   },
  devServer: {
    index: 'index.html',
    port: 9393,
    open: true
  }
};