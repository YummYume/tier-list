/* eslint-env node */

const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');
let watch = null;

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore.setOutputPath('public/build/')
    .setPublicPath('/jquery/public/build')
// needed because of /jquery subdirectory
    .setManifestKeyPrefix('build')
    .addEntry('app', './assets/app.js')
    .autoProvidejQuery()
    .splitEntryChunks()
// will require an extra script tag for runtime.js
// but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
// enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
// enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv(config => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enablePostCssLoader()
    .configureDefinePlugin(() => {
        const env = dotenv.config();

        if (env.error) {
            throw env.error;
        }

        watch = env.parsed.WATCH;
    });

module.exports = Encore.getWebpackConfig();

if (watch === 'true') {
    module.exports = {
        ...module.exports,
        watch: true,
        watchOptions: {
            aggregateTimeout: 200,
            poll: 1000
        }
    };
}
