noconst elixir = require('laravel-elixir');

require('laravel-elixir-vue');

elixir(mix=>{
    mix.sass('app.scss');
    mix.webpack('app.js');

    mix.scripts([
        '../../../node_modules/highlightjs/highlight.pack.js',
        '../../../public/js/app.js',
        '../../../node_modules/select2/dist/js/select2.js',
        '../../../node_modules/dropzone/dist/dropzone.js',
        '../../../node_modules/marked/lib/marked.js',
        '../../../node_modules/jquery-tabby/jquery.textarea.js',
        '../../../node_modules/autosize/dist/autosize.js',
        'forum.js'
    ], 'public/js/app.js');


    mix.version([
        'css/app.css',
        'js/app.js'
    ]);
    mix.copy('node_modules/font-awesome/fonts', 'public/build/fonts');
});
