const Encore = require("@symfony/webpack-encore");

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || "dev");
}

Encore.setOutputPath("public/build/")
    .setPublicPath("/build")
    .addEntry("app", "./assets/app.ts")
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableIntegrityHashes(Encore.isProduction())
    .enableStimulusBridge("./assets/controllers.json")
    .enablePostCssLoader()
    .enableTypeScriptLoader()
    .enableVueLoader()
    .copyFiles({
        from: "./assets/img",
        to: "img/[path][name].[ext]",
    });

module.exports = Encore.getWebpackConfig();
