<?php

class madbCleanPropelGeneratedFilesTask extends madbBaseTask
{
  protected function configure()
  {
    $this->namespace        = 'madb';
    $this->name             = 'clean-propel-generated-files';
    $this->briefDescription = 'Removes non-version-controlled propel-generated files (lib/model/om/*, etc.)';
    $this->aliases   = array('clean-propel');
  }

  protected function execute($arguments = array(), $options = array())
  {
    $paths = array(
      'data/sql/',
      'lib/filter/base/',
      'lib/form/base/',
      'lib/model/map/',
      'lib/model/om/',
      'plugins/sfGuardPlugin/lib/filter/base/',
      'plugins/sfGuardPlugin/lib/form/base/',
      'plugins/sfGuardPlugin/lib/model/map/',
      'plugins/sfGuardPlugin/lib/model/om/'
    );
    
    foreach ($paths as $path)
    {
      $this->getFilesystem()->remove(sfFinder::type('file')->in($path));
    }
    $this->log("Propel generated files deleted, now you need to re-create them");
  }
}
