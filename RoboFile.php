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

        $this
            ->taskWatch()
            ->monitor(array('app/Resources/assets/sass/'), $buildCss)
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

                'resources/assets/js/vendor/jquery/jquery.ui.core.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.core.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.position.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.widget.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.mouse.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.draggable.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.resizable.min.js',
                'resources/assets/js/vendor/jquery/jquery.ui.dialog.min.js',

                'resources/assets/js/vendor/tipsy/jquery.tipsy.js',

                'resources/assets/js/../fancybox/jquery.easing-1.3.pack.js',
                'resources/assets/js/../fancybox/jquery.fancybox-1.3.4.js',
                'resources/assets/js/../fancybox/jquery.fancybox-1.3.4.pack.js',
                'resources/assets/js/../fancybox/jquery.mousewheel-3.0.4.pack.js',

                'resources/assets/js/filtering.js',
                'resources/assets/js/jquery.selectToCheckboxes.js',
                'resources/assets/js/searchform.js',
                'resources/assets/js/tooltip.js',
                'resources/assets/js/header.js',

                'resources/assets/js/package.js',
            ])
            //->to('cache/assets/main.js')
            ->to('web/assets/js/main.js')
            ->run()
        ;

        /*$this
            ->taskMinify('cache/assets/main.js')
            ->to('web/assets/js/main.js')
            ->run()
        ;*/

        $this->taskHash('web/assets/js/main.js')->to('web/assets/js/')->run();
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
        $this->_copyDir('resources/assets/sass/css/vendor/font-awesome/font/', 'web/assets/font');
    }
}
