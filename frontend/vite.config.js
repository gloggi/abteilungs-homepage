import { defineConfig } from "vite";
import Vue from "@vitejs/plugin-vue";
import svgLoader from "vite-svg-loader";

const path = require("path");

export default defineConfig({
  plugins: [Vue(), svgLoader()],
  server: {
    port: 8080,
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
  },
});
