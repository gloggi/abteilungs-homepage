module.exports = {
  publicPath: process.env.NODE_ENV === "production" ? "/" : "/",
  devServer: {
    client: {
      webSocketURL: "ws://0.0.0.0:80/frontend/ws",
    },
    allowedHosts: "all",
  },
};
