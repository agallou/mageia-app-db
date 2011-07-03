<?php

class criteriaHelperFactory
{

  public function createDefault()
  {
    $con = Propel::getConfiguration();
    $adapter = $con['datasources']['propel']['adapter'];
    if ($adapter == 'pgsql')
    {
      $adapter = 'postgresql';
    }
    return $this->createFromType($adapter);
  }

  /**
   * createFromType 
   * 
   * @param string $type 
   *
   * @return criteriaHelperInterface
   */
  public function createFromType($type)
  {
    $class = $this->getClassnameFromType($type);
    //TODO check interface
    return new $class();
  }

  /**
   * getClassnameFromType 
   * 
   * @param string $type 
   *
   * @return string
   */
  protected function getClassnameFromType($type)
  {
    return 'criteriaHelper'. ucfirst($type);
  }

}
