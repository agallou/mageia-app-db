<?php
class dbInfos
{
  protected $host;
  protected $user;
  protected $password;
  protected $name;

  public function getHost()
  {
    return $this->host;
  }

  public function getUser()
  {
    return $this->user;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setHost($host)
  {
    $this->host = $host;
  }

  public function setUser($user)
  {
    $this->user = $user;
  }

  public function setPassword($password)
  {
    $this->password = $password;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

}
