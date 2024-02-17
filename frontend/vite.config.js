import { defineConfig } from "vite";
import Vue from "@vitejs/plugin-vue";

const path = require("path");

export default defineConfig({
  plugins: [Vue()],
  server: {
    port: 8080,
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "src"),
    },
  },
});
