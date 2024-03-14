import { defineConfig } from "vite";
import Vue from "@vitejs/plugin-vue";
import svgLoader from "vite-svg-loader";
import { resolve } from 'path';

export default defineConfig({
  plugins: [Vue(), svgLoader()],
  server: {
    port: 8080,
  },
  resolve: {
    alias: {
      "@": resolve(__dirname, "src"),
    },
  },
});
