var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

elixir(function(mix) {
    mix.browserify('main.js'); // mix.browserify(srcPath, outputPath, srcBaseDir, browserifyOptions)
});
