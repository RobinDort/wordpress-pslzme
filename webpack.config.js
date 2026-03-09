const path = require("path");

module.exports = {
	mode: "production", // or 'development'
	entry: "./public/js/3D/pslzme-3d.js",
	output: {
		filename: "pslzme-3d.bundle.js",
		path: path.resolve(__dirname, "public/js/bundles"), // output folder
	},
	module: {
		rules: [
			{
				test: /\.m?js$/,
				exclude: /(node_modules|bower_components)/,
				use: {
					loader: "babel-loader",
					options: {
						presets: ["@babel/preset-env"], // transpile modern JS
					},
				},
			},
		],
	},
	resolve: {
		alias: {
			three: path.resolve(__dirname, "node_modules/three"),
		},
	},
};
