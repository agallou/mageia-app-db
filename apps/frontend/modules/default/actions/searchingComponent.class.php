<?php
class searchingComponent extends madbComponent
{
  public function execute($request)
  {
    $request     = $this->getRequest();
    $module      = $this->module_to ? $this->module_to : $request['module'];
    $action      = $this->action_to ? $this->action_to : $request['action'];
    $internalUri = sprintf('%s/%s', $module, $action);
    $ignored     = array('t_search', 'search', 'page');
    if ($this->module_to)
    {
      $this->showTitle = false;
      $this->showinfos = false;
      $keep_all_parameters = false;
    }
    else
    {
      $this->showTitle = true;
      $this->showinfos = true;
      $keep_all_parameters = true;
    }
    $this->url   = $this->getMadbUrl()->urlFor($internalUri, $this->getMadbContext(), array(
      'keep_all_parameters' => $keep_all_parameters,  
      'ignored_parameters' => $ignored,
    ));
    $request           = $this->getRequest();
    $internalUri       = sprintf('%s/%s', $request['module'], $request['action']);
    $this->urldelete   = $this->getMadbUrl()->urlFor($internalUri, $this->getMadbContext(), array(
      'keep_all_parameters' => true,  
      'ignored_parameters' => array('t_search', 'search', 'page'),
    ));
  }
}
