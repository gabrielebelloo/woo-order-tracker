const defaults = require('@wordpress/scripts/config/webpack.config');

module.exports = {
  ...defaults,
  entry: './react-src/index.js',
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
    'wp-element': 'wp.element'
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env', '@babel/preset-react'],
          },
        },
      },
    ],
  },
};