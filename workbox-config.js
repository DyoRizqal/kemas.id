module.exports = {
	globDirectory: 'public/',
	globPatterns: [
		'**/*.{js,md,css,txt,png,svg,html,php,jpg,json,eot,ttf,woff,gif,ico,woff2,webmanifest,config}'
	],
	swDest: 'public/sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};