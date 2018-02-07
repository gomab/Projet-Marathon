const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const ExtractTextPlugin = require("extract-text-webpack-plugin");

const UglifyJsPlugin = require('uglifyjs-webpack-plugin');


module.exports = merge(common,{
    module: {
        // SASS
        rules: 
        [
            {
            test: /\.scss$/,
            use: ExtractTextPlugin.extract({
                fallback: 'style-loader',
                use: [ // use sass + css loader
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1,
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            ident: 'postcss',
                            plugins: (loader) => [
                              require('autoprefixer')(),
                              require('cssnano')(),
                              require('css-mqpacker')(),
                            ]
                        } 
                    },
                    {
                        loader: 'sass-loader',
                    },
                ],
            })
        }
    ]
    },
    plugins: [
        new UglifyJsPlugin({}),
    ],
});