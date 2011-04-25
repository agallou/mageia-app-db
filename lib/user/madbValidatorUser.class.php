<?php
class madbValidatorUser extends sfGuardValidatorUser
{

  protected function doClean($values)
  {
    // only validate if username and password are both present
    if (isset($values[$this->getOption('username_field')]) && isset($values[$this->getOption('password_field')]))
    {
      $username = $values[$this->getOption('username_field')];
      $password = $values[$this->getOption('password_field')];

      $madbConnectorFactory = new madbUserConnectorFactory(null, null, $username, $password);
      $madbConnector        = $madbConnectorFactory->create(sfConfig::get('app_user_connector'));

      if ($user = $madbConnector->retrieveSfGuardUser($username))
      {
        // password is ok?
        if ($user->getIsActive() && $user->checkPassword($password))
        {
          return array_merge($values, array('user' => $user));
        }
      }

      if ($this->getOption('throw_global_error'))
      {
        throw new sfValidatorError($this, 'invalid');
      }

      throw new sfValidatorErrorSchema($this, array(
        $this->getOption('username_field') => new sfValidatorError($this, 'invalid'),
      ));
    }
  }
 
}
