<?php

class generateMoTask extends sfBaseTask
{
  protected function configure()
  {
    $this->namespace        = 'generate';
    $this->name             = 'mo';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $files = sfFinder::type('file')->name('*.po')->in(sfConfig::get('sf_root_dir') . '/apps/frontend/i18n');
    foreach ($files as $file)
    {
      $pathinfo = pathinfo($file);
      $cmdFormat = 'msgfmt %s -o %s';
      $cmd = sprintf($cmdFormat, $file, $pathinfo['dirname'] . DIRECTORY_SEPARATOR . $pathinfo['filename'] . '.mo');
      $this->getFilesystem()->execute($cmd);
    }
  }
}
