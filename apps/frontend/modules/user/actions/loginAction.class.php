<?php
class loginAction extends sfActions
{
  public function execute($request)
  {
    $this->form = new loginUserForm();
    if ($request->isMethod(sfRequest::POST))
    {
      $parameters = array(
        'login'       => $request->getParameter('login'),
        'password'    => $request->getParameter('password'),
      );
      $this->form->bind($parameters);
      if ($this->form->isValid())
      {
        $this->getUser()->login($this->form->getValue('login'), $this->form->getValue('password'));
      }
    }
    if ($this->getUser()->isAuthenticated())
    {
      $this->redirect('@homepage');
    }
  }
}
