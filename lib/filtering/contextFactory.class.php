<?php
class contextFactory
{

  public function createFromRequest(sfRequest $request)
  {
    $parameterHolder = new madbParameterHolder();
    $context         = new madbContext($parameterHolder);
    return $context;
  }
}
