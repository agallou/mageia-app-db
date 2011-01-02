<?php
class filterFactory
{

  public function create($name)
  {
    $classname = $name . 'CriteriaFilter';
    if (!class_exists($classname))
    {
      throw new filterFactoryException(sprintf('filter %s not found', $name));
    }
    return new $classname;
  }

}
