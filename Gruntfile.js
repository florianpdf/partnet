module.exports = function(grunt) {

    require('time-grunt')(grunt); // Displays the elapsed execution time of tasks

    // JIT (Just In Time) plugin loader
    // "Second parameter is static mappings. It is used when there is a plugin that can not be resolved in the automatic mapping."
    require('jit-grunt')(grunt, {
        sprite: 'grunt-spritesmith'
    });


    // Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),


        // Concatenation /////////////////////////////////////////////////////////
        concat: {
            scripts: {
                src: ['app/Resources/js/scripts/*.js', 'app/Resources/js/*.js',
                    'src/**/Resources/public/js/*.js'],
                dest: 'web/js/dev/scripts.js',
            },
            polyfills: {
                src: ['app/Resources/js/polyfills/*.js'],
                dest: 'web/js/dev/polyfills.js',
            }
        },


        // CSS processing ////////////////////////////////////////////////////////
        sass: {
            options: {
                indentedSyntax: true,
                indentType: 'tab',
                indentWidth: 1
            },
            target: { files: { 'web/css/dev/main.css': 'app/Resources/css/global.scss' } }
        },

        autoprefixer: {
            options: { browsers: ['last 5 versions', 'Opera >= 12', 'ie >= 9'] },
            target: { files: { 'web/css/dist/main.min.css': 'web/css/dev/main.css' } },
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
                normalizeCharset: false,
                uniqueSelectors: true,
                zindex: true,
            },
            target: { files: { 'web/css/dist/main.min.css': 'web/css/dist/main.min.css' } }
        },


        // JS minifcation ////////////////////////////////////////////////////////
        uglify: {
            scripts: { files: { 'web/js/dist/scripts.min.js': 'web/js/dev/scripts.js' } },
            polyfills: { files: { 'web/js/dist/polyfills.min.js': 'web/js/dev/polyfills.js' } }
        },


        // Sprites ///////////////////////////////////////////////////////////////
        sprite: {
            all: {
                src: 'src/**/Resources/public/images/sprite-elements/*.*',
                dest: 'app/Resources/images/spritesheet.png',
                destCss: 'app/Resources/css/_sprite.scss'
                //cssFormat: 'css'
            }
        },


        // Images ////////////////////////////////////////////////////////////////
        imagemin: {
            all: {
                options: {
                    optimizationLevel: 7
                },
                files: [{
                    expand: true,
                    flatten: true,
                    src: ['app/Resources/images/*.{png,jpg,gif,svg}', 'src/**/Resources/public/images/*.{png,jpg,gif,svg}'],
                    dest: 'web/images/'
                }]
            }
        },


        // Clean /////////////////////////////////////////////////////////////////
        clean: ["app/Resources/css/_sprite.scss", 'app/Resources/images/spritesheet.png',
            "web/js/dev/*", "web/js/dist/*",
            "web/css/dev/*", "web/css/dist/*"],


        // Browsersync ///////////////////////////////////////////////////////////
        browserSync: {
            bsFiles: {
                src : 'web/css/dev/main.css'
            },
            options: {
                watchTask: true,
                proxy: (process.platform === "darwin" ? "http://localhost:8888/project_partnet/web/app_dev.php/" :
                    "http://localhost/partnet/web/app_dev.php/")
            }
        },
        // Monitoring ////////////////////////////////////////////////////////////
        watch: {
            scripts: {
                files: ['app/Resources/js/scripts/*.js', 'app/Resources/js/*.js',
                    'src/**/Resources/public/js/*.js'],
                tasks: ['concat:scripts']
            },
            polyfills: {
                files: ['app/Resources/js/polyfills/*.js'],
                tasks: ['concat:polyfills']
            },
            css: {
                files: ['app/Resources/css/**/*.scss', 'src/**/Resources/public/css/*.scss'],
                tasks: ['sass']
            }
        }
    });

    // Tasks
    grunt.registerTask('default', ['clean', 'sprite', 'imagemin', 'concat', 'uglify', 'sass', 'autoprefixer', 'cssnano', 'browserSync', 'watch']);

};