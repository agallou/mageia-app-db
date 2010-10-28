<?php
class madbUser extends sfBasicSecurityUser
{
  public function login($login, $password)
  {
    $user = UserPeer::retrieveByLogin($login);
    if (!is_null($user))
    {
      $this->setAuthenticated(true);
    }
  }
}
