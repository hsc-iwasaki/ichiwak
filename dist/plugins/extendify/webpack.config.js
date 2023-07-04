const defaultConfig = require('@wordpress/scripts/config/webpack.config')
const { resolve } = require('path')

module.exports = {
    ...defaultConfig,
    devServer: {
        ...defaultConfig.devServer,
        host: process.env.WP_DEVHOST || 'wordpress.test',
    },
    plugins: [...defaultConfig.plugins],
    resolve: {
        ...defaultConfig.resolve,
        alias: {
            ...defaultConfig.resolve.alias,
            '@library': resolve(__dirname, 'src/Library'),
            '@onboarding': resolve(__dirname, 'src/Onboarding'),
            '@assist': resolve(__dirname, 'src/Assist'),
            '@chat': resolve(__dirname, 'src/Chat'),
        },
    },
    entry: {
        extendify: './src/Library/app.js',
        'extendify-onboarding': './src/Onboarding/app.js',
        'extendify-assist': './src/Assist/app.js',
        'extendify-chat': './src/Chat/app.js',
        'editorplus.min': './editorplus/editorplus.js',
    },
    output: {
        filename: '[name].js',
        path: resolve(process.cwd(), 'public/build'),
    },
}
