<?php
class madbUserConnector
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
   * checkPassword 
   * 
   * @return bool
   */
  public function checkPassword()
  {
    return $this->getGuardUser()->checkPasswordByGuard($this->getPassword());
  }

  /**
   * retrieveSfGuardUser 
   * 
   * @return sfGuardUser|null
   */
  public function retrieveSfGuardUser()
  {
    return sfGuardUserPeer::retrieveByUsername($this->getUsername());
  }

  /**
   * getUser 
   * 
   * @return User
   */
  protected function getUser()
  {
    return $this->user;
  }

  /**
   * getGuardUser 
   * 
   * @return PluginsfGuardUser
   */
  public function getGuardUser()
  {
    return $this->guardUser;
  }

  /**
   * getUsername 
   * 
   * @return string
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * getPassword 
   * 
   * @return string
   */
  protected function getPassword()
  {
    return $this->password;
  }

}
