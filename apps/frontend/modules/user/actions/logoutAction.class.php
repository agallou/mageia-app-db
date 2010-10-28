<?php
class logoutAction extends sfActions
{
  public function execute($request)
  {
    $this->getUser()->setAuthenticated(false);
    $this->redirect('@homepage');
  }
}
