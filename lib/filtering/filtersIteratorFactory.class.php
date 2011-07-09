<?php
class filtersIteratorFactory
{

  /**
   * 
   * Creates a filtersIterator object containing either all available filters or a given list of filters
   * @param array $only_those if empty array means "all filters", otherwise is an array of filter codes
   */
  public function create($only_those = array())
  {
    $files         = sfFinder::type('file')->name('*.php')->in(sfConfig::get('sf_lib_dir') . DIRECTORY_SEPARATOR . 'filtering/filters');
    $names         = $this->getFiltersNamesFromFiles($files);
    $filters       = array();
    $filterFactory = new filterFactory();
    foreach ($names as $name)
    {
      $filter = $filterFactory->create($name);
      if (empty($only_those) or in_array($filter->getCode(), $only_those))
      {
        $filters[] = $filter;
      } 
    }
    return new filtersIterator($filters);
  }

  protected function getFiltersNamesFromFiles(array $files)
  {
    $files        = array_map('basename', $files);
    $filtersNames = array();
    foreach ($files as $file)
    {
      $filtersNames[] = substr($file, 0, -24);
    }
    return $filtersNames;
  }
}
