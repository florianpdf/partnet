module.exports = function(grunt) {

    require('time-grunt')(grunt); // Displays the elapsed execution time of tasks
    require('jit-grunt')(grunt);  // JIT (Just In Time) plugin loader


    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),


        // Concatenation /////////////////////////////////////////////////////////
        concat: {
            scripts: {
                src: ['app/Resources/js/_scripts/*.js', 'app/Resources/js/*.js'],
                dest: 'js/dev/scripts.js',
            },
            polyfills: {
                src: ['app/Resources/js/_polyfills/*.js'],
                dest: 'app/Resources/js/dev/polyfills.js',
            },
            css: {
                src: ['app/Resources/css/*.scss'],
                dest: 'app/Resources/css/temp/main.scss',
            }
        },


        // CSS processing ////////////////////////////////////////////////////////
        sass: {
            options: {
                indentedSyntax: true,
                indentType: 'tab',
                indentWidth: 1
            },
            target: { files: { 'app/Resources/css/dev/main.css': 'app/Resources/css/global.scss' } }
        },

        autoprefixer: {
            options: { browsers: ['last 5 versions', 'Opera >= 12', 'ie >= 9'] },
            target: { files: { 'app/Resources/css/dist/main.min.css': 'app/Resources/css/dev/main.css' } },
        },

        cssnano: {
            options: {  // http://cssnano.co/optimisations/
                sourcemap: false,
                autoprefixer: false,
                calc: false,
                colormin: true,
                convertValues: true,
                discardComments: true,
                discardDuplicates: true,
                discardEmpty: true,
                discardUnused: true,
                filterPlugins: true,
                functionOptimiser: true,
                mergeIdents: true,
                mergeLonghand: true,
                mergeRules: false,
                minifyFontValues: true,
                minifySelectors: true,
                normalizeUrl: true,
                orderedValues: true,
                reduceIdents: true,
                singleCharset: false,
                uniqueSelectors: true,
                zindex: true,
            },
            target: { files: { 'app/Resources/css/dist/main.min.css': 'app/Resources/css/dist/main.min.css' } }
        },


        // JS minifcation ////////////////////////////////////////////////////////
        uglify: {
            scripts: { files: { 'app/Resources/js/dist/scripts.min.js': 'app/Resources/js/dev/scripts.js' } },
            polyfills: { files: { 'app/Resources/js/dist/polyfills.min.js': 'app/Resources/js/dev/polyfills.js' } }
        },


        // Clean /////////////////////////////////////////////////////////////////
        clean: ["app/Resources/js/dev/*", "app/Resources/js/dist/*", "app/Resources/css/dev/*", "app/Resources/css/dist/*", "app/Resources/css/temp/*"],


        // Monitoring ////////////////////////////////////////////////////////////
        watch: {
            scripts: {
                files: ['app/Resources/js/_scripts/*.js', 'app/Resources/js/*.js'],
                tasks: ['concat:scripts']
            },
            polyfills: {
                files: ['app/Resources/js/_polyfills/*.js'],
                tasks: ['concat:polyfills']
            },
            css: {
                files: ['app/Resources/css/*.scss'],
                tasks: ['sass']
            }
        }
    });

    // Tasks
    grunt.registerTask('default', ['clean', 'concat', 'uglify', 'sass', 'autoprefixer', 'cssnano', 'watch']);

};