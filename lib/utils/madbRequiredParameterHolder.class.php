<?php
class madbRequiredParameterHolder extends sfParameterHolder
{

  private $requiredParameters = array();

  public function setRequiredParameters($parametersNames)
  {
    $this->requiredParameters = $parametersNames;
  }

  public function add($parameters)
  {
    $ret  = parent::add($parameters);
    $keys = array_keys($parameters);
    foreach ($this->requiredParameters as $parameter)
    {
      if (!in_array($parameter, $keys))
      {
        throw new sfException(sprintf('Parameter %s should be added', $parameter));
      }
    }
    return $ret;
  }

}
