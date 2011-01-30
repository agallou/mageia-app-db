<?php

class searchInfosComponent extends madbComponent
{
  public function execute($request)
  {
    $this->madbcontext = $this->getMadbContext();
    $request           = $this->getRequest();
    $internalUri       = sprintf('%s/%s', $request['module'], $request['action']);
    $this->urldelete   = $this->getMadbUrl()->urlFor($internalUri, $this->getMadbContext(), array(
      'ignored_parameters' => array('t_search', 'search'),
    ));

  }
}
