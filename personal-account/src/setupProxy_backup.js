const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = function (app) {
  app.use(
    '/api',  // Any requests starting with /api will be proxied
    createProxyMiddleware({
      target: 'https://insure.a-group.az',  // Target API
      changeOrigin: true,  // Change the origin to match the target
      secure: false,  // Skip SSL verification
      pathRewrite: { '^/api': '' },  // Strip /api from the path
    })
  );
};
