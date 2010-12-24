<?php
class filterPerimeters 
{

  const RPM     = 'rpm';
  const PACKAGE = 'package';

  public function get($name)
  {
    $classname = $this->getClassname($name);
    return new $classname;
  }

  protected function getClassname($name)
  {
    return $name . 'Perimeter';
  }

  public function getAll()
  {
    return array(
      self::RPM,
      self::PACKAGE
    );
  }

}
