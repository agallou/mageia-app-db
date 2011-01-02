<?php
class filterIteratorFactory
{

  public function create()
  {
    $files         = sfFinder::type('file')->name('*.php')->in(sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR . 'filtering/filters');
    $names         = $this->getFiltersNamesFromFiles($files);
    $filters       = array();
    $filterFactory = new filterFactory();
    foreach ($names as $name)
    {
      $filters[] = $filterFactory->create($name);
    }
    return new filtersIterator($filters);
  }

  protected function getFiltersNamesFromFiles(array $files)
  {
    $files        = array_map('basename', $files);
    $filtersNames = array();
    foreach ($files as $file)
    {
      $filersNames[] = substr($file, 0, -24);
    }
    return $filersNames;
  }
}
