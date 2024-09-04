const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = function (app) {
  app.use(
    '/api',
    createProxyMiddleware({
      target: 'https://insure.a-group.az',  // Target API
      changeOrigin: true,                    // Ensures the host header is changed to match the target
      secure: false,                         // Skip SSL verification for development
      pathRewrite: { '^/api': '' },          // Rewrites '/api' to '' before forwarding the request
    })
  );
};
