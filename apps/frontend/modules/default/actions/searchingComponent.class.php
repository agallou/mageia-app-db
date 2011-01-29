<?php
class searchingComponent extends madbComponent
{
  public function execute($request)
  {
    $request     = $this->getRequest();
    $module      = $this->module_to ? $this->module_to : $request['module'];
    $action      = $this->action_to ? $this->action_to : $request['action'];
    $internalUri = sprintf('%s/%s', $module, $action);
    $ignored     = array('t_search', 'search');
    if ($this->module_to)
    {
      $ignored[] = 't_group';
    }
    $this->url   = $this->getMadbUrl()->urlFor($internalUri, $this->getMadbContext(), array(
      'ignored_parameters' => $ignored,
    ));
    $this->showTitle = !(bool)$this->module_to;
  }
}
