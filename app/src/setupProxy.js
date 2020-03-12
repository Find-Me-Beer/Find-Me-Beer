const proxy = require('http-proxy-middleware');
module.exports = function(app) {
	app.use(proxy('/apis', {
		logLevel: 'debug',
		target: "https://bootcamp-coders.cnm.edu/~variasantonov/Find-Me-Beer/php/public_html/apis/",
		changeOrigin: true,
		secure: true, }));
};