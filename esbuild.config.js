const ESBuild = require("esbuild");
const path = require("path");

const mode = process.env.NODE_ENV || "development";

const isDev = mode === "development";
const isProd = mode === "production";

ESBuild.build({
    entryPoints: [
        "./src/ts/pages/web/index.ts",
        "./src/ts/pages/admin/index.ts",
    ],
    bundle: true,
    platform: "browser",
    tsconfig: "tsconfig.json",
    entryNames: "[dir]/[name]",
    outdir: path.resolve(__dirname, "public", "build", "js"),
    minify: isProd,
    sourcemap: isDev,
    watch: isDev,
});
