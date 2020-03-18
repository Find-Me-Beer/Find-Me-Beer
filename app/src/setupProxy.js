const proxy = require('http-proxy-middleware');
module.exports = function(app) {
	app.use(proxy('/apis', {
		logLevel: 'debug',
		target: "https://bootcamp-coders.cnm.edu/~rnunn4/Find-Me-Beer/php/public_html/",
		changeOrigin: true,
		secure: true, }));
};