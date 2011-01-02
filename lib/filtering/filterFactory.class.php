<?php
class filterFactory
{

  public function create($name)
  {
    $classname = $name . 'CriteriaFilter';
    //TODO exception
    return new $classname;
  }

}
