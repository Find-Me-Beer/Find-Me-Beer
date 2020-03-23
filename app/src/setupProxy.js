const proxy = require('http-proxy-middleware');
module.exports = function(app) {
	app.use(proxy('/apis', {
		logLevel: 'debug',
		target: "https://abqfindmebeer.com",
		changeOrigin: true,
		secure: true, }));
};