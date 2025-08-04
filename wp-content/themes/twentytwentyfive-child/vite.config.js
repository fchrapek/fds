import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  base:
    process.env.NODE_ENV === "production"
      ? "/wp-content/themes/twentytwentyfive-child/dist/"
      : "/",

  build: {
    manifest: "manifest.json",
    assetsDir: ".",
    outDir: "dist",
    emptyOutDir: true,
    rollupOptions: {
      input: [
        "assets/js/scripts.js",
        "assets/scss/styles.scss",
      ],
      output: {
        entryFileNames: "[name].[hash].js",
        assetFileNames: "[name].[hash].[ext]",
        chunkFileNames: "[name].[hash].js",
      },
    },
  },

  css: {
    preprocessorOptions: {
      scss: {
        silenceDeprecations: ["legacy-js-api"],
      },
    },
  },

  plugins: [
    {
      name: "php-hot-reload",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".php")) {
          server.ws.send({ type: "full-reload" });
          return [];
        }
      },
    },

    {
      name: "dev-log",
      configureServer(server) {
        console.clear();
        console.log("\x1b[92mStatus:\x1b[0m ", "Vite is Running 🚀");
        console.log("\x1b[92mServer:\x1b[0m ", "http://fooz.test");
        console.log("\x1b[92mAssets:\x1b[0m ", "http://localhost:3000");
      },
    },
  ],

  server: {
    cors: {
      origin: "http://fooz.test",
      credentials: true,
    },
    host: "localhost",
    port: 3000,
    hmr: {
      host: "localhost",
      port: 3000,
    },
    watch: {
      usePolling: true,
      interval: 100,
    },
  },

  resolve: {
    alias: {
      "@": path.resolve(__dirname, "assets"),
      "@js": path.resolve(__dirname, "assets/js"),
      "@scss": path.resolve(__dirname, "assets/scss"),
    },
  },
});
