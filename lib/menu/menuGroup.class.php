<?php
class menuGroup extends ArrayIterator
{

  private $name;

  public function __construct($name = null, $array = array())
  {
    $this->name = $name;
    parent::__construct($array);
  }

  public function addMenuItem(menuItem $item)
  {
    $this->append($item);
  }

  public function addMenuGroup(menuGroup $group)
  {
    $this->append($group);
  }

  public function getName()
  {
    return $this->name;
  }

  public function append($value)
  {
    parent::append($value);
  }

}

