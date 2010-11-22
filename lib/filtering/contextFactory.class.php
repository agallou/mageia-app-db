<?php
class contextFactory
{

  public static function createFromRequest(sfRequest $request)
  {
    $parameterHolder = new madbParameterHolder();
    foreach ($request->getParameterHolder()->getAll() as $key => $value)
    {
      $parameterHolder->set($key, $value);
    }
    $context         = new madbContext($parameterHolder);
    return $context;
  }
}
