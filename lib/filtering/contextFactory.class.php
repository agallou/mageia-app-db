<?php
class contextFactory
{

  public function createFromRequest(sfRequest $request)
  {
    $parameterHolder = new madbParameterHolder();
    $allParameters   = $request->getParameterHolder()->getAll();
    unset($allParameters['module']);
    unset($allParameters['action']);
    foreach ($allParameters as $key => $value)
    {
      $parameterHolder->set($key, $value);
    }
    $context = new madbContext($parameterHolder);
    return $context;
  }
}
