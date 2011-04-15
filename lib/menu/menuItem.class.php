<?php
class menuItem
{

  public function __construct($name, $internalUri = null, $options = array())
  {
    if (!is_string($name))
    {
      throw new menuItemException('invalid name');
    }
    if ($internalUri !== null && !is_string($internalUri))
    {
      throw new menuItemException('invalid name');
    }
    $this->name = $name;
    $this->internalUri = $internalUri;
    $this->options = $options;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getInternalUri()
  {
    return $this->internalUri;
  }

  public function getOptions()
  {
    return $this->options;
  }

}
