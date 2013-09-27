<?php
class menuGroup extends ArrayIterator
{

  private $name;
  private $icon;

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

  public function setIcon($icon)
  {
    $this->icon = $icon;
  }

  public function getIcon()
  {
    return $this->icon;
  }

  public function append($value)
  {
    if ($value instanceof menuItem || $value instanceof menuGroup)
    {
      parent::append($value);
    }
    else
    {
      throw new menuGroupException('append value must be a menuGroup or menuItem');
    }
  }

}

