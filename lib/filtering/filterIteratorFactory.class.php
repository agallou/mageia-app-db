<?php
class filterIteratorFactory
{

  public function create()
  {
    $files   = sfFinder::type('file')->in(sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR . 'filtering/filters');
    $files   = array_map('basename', $files);
    $classes = array();
    foreach ($files as $file)
    {
      $classes[] = substr($file, 0, -10);
    }
    $classes = array_filter($classes, 'class_exists');
    $filters = array();
    //TODO use fiterFactory
    //TODO create method getFiltersNames from sfFinder ou list of files
    //TODO catch del'exception du filterFactory
    foreach ($classes as $class)
    {
      $filters[] = new $class;
    }
    return new filtersIterator($filters);
  }
}
