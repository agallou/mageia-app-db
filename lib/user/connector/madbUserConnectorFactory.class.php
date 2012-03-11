<?php
class madbUserConnectorFactory
{

  /**
   * user 
   * 
   * @var MadbUser
   */
  private $user;

  /**
   * guardUser 
   * 
   * @var PluginsfGuardUser
   */
  private $guardUser;

  /**
   * username 
   * 
   * @var string
   */
  private $username;

  /**
   * password 
   * 
   * @var string
   */
  private $password;

  /**
   * __construct 
   * 
   * @param MadbUser          $user 
   * @param PluginsfGuardUser $guardUSer 
   * @param mixed             $username 
   * @param mixed             $password 
   *
   * @return void
   */
  public function __construct(MadbUser $user = null, PluginsfGuardUser $guardUser = null, $username = null, $password = null)
  {
    $this->user      = $user;
    $this->guardUser = $guardUser;
    $this->username  = $username;
    $this->password  = $password;
  }

  /**
   * create 
   * 
   * @param string $type 

   * @return madbUserConnector
   */
  public function create($type)
  {
    if ($type == 'default')
    {
      $classname = 'madbUserConnector';
    }
    else
    {
      $classname = sprintf('madbUserConnector%s', sfInflector::camelize($type));
    }
    if (class_exists($classname))
    {
      return new $classname($this->user, $this->guardUser, $this->username, $this->password);
    }

    throw new madbUserConnectorFactoryException(sprintf('userConnector "%s" not found (%s)', var_export($type, true), $classname));
  }
}
