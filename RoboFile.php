<?php

class RoboFile extends \Robo\Tasks
{
    use Agallou\RoboHash\loadTasks;

    public function watch()
    {
        $this->build();

        $buildCss = function () {
            $this->_cleanBase();
            $this->_cleanCss();
            $this->_buildCss();
        };

        $buildJs = function () {
            $this->_cleanBase();
            $this->_cleanJs();
            $this->_buildJs();
        };

        $this
            ->taskWatch()
            ->monitor('resources/assets/sass', $buildCss)
            ->monitor('resources/assets/js', $buildJs)
            ->run()
        ;
    }

    public function install()
    {
        $this->getDeps();
        $this->build();
    }

    protected function getDeps()
    {
        $this->_mkdir('bower_components/');
        $this->_cleanDir('bower_components/');
        $this->taskBowerInstall('./bin/bowerphp')->run();
    }

    public function build()
    {
        $this->_clean();
        $this->_buildCss();
        $this->_buildJs();
        $this->_buildOtherAssets();
    }

    protected function _buildCss()
    {
        $this->copySass();

        $this
            ->taskScss(['resources/assets/sass/main.scss' => 'cache/assets/sass/main_sass.css'])
            ->addImportPath('resources/assets/sass')
            ->addImportPath('bower_components/compass-mixins/lib/')
            ->run();

        $this
            ->taskConcat([
                'cache/assets/sass/main_sass.css',
            ])
            ->to('cache/main.css')
            ->run()
        ;

        $this
            ->taskMinify('cache/main.css')
            ->to('web/assets/css/main.css')
            ->run()
        ;

        $this->taskHash('web/assets/css/main.css')->to('web/assets/css/')->run();
    }

    protected function _buildJs()
    {
        $this
            ->taskConcat([
                'bower_components/jquery/jquery.js',
                'bower_components/js-base64/base64.js',

                'bower_components/tipsy/src/javascripts/jquery.tipsy.js',

                'bower_components/colorbox/jquery.colorbox.js',

                'resources/assets/js/filtering.js',
                'resources/assets/js/jquery.selectToCheckboxes.js',
                'resources/assets/js/searchform.js',
                'resources/assets/js/tooltip.js',
                'resources/assets/js/header.js',
                'resources/assets/js/screenshots.js',

                'resources/assets/js/package.js',
            ])
            ->to('cache/assets/main.js')
            ->run()
        ;

        $this
            ->taskMinify('cache/assets/main.js')
            ->keepImportantComments(false)
            ->to('web/assets/js/main.js')
            ->run()
        ;

        $this->taskHash('web/assets/js/main.js')->to('web/assets/js/')->run();
    }

    protected function copySass()
    {
        $this->_copy('bower_components/tipsy/src/stylesheets/tipsy.css', 'cache/assets/sass-copies/tipsy.scss');
        $this->_copy('bower_components/colorbox/example2/colorbox.css', 'cache/assets/sass-copies/colorbox.scss');
    }

    protected function _clean()
    {
        $this->_mkdir('cache/assets/');
        $this->_cleanBase();
        $this->_cleanCss();
        $this->_cleanJs();
        $this->_cleanOtherAssets();

    }

    protected function _cleanBase()
    {
        $this->_cleanDir('cache/assets/');
    }

    protected function _cleanCss()
    {
        $this->_mkdir('web/assets/css');
        $this->_cleanDir('web/assets/css');
        $this->_mkdir('cache/assets/sass');
        $this->_cleanDir('cache/assets/sass');
        $this->_mkdir('cache/assets/sass-copies');
        $this->_cleanDir('cache/assets/sass-copies');
    }

    protected function _cleanJs()
    {
        $this->_mkdir('web/assets/js');
        $this->_cleanDir('web/assets/js');
    }

    protected function _cleanOtherAssets()
    {
        $this->_mkdir('web/assets/font');
        $this->_cleanDir('web/assets/font');
    }

    protected function _buildOtherAssets()
    {
        $this->_copyDir('bower_components/fontawesome/font/', 'web/assets/font');
        $this->_copyDir('bower_components/colorbox/example2/images/', 'web/assets/css/images/');
    }
}
