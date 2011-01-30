<?php
class dbInfosFactory
{

  public static function createFromPropelConfiguration($configuration)
  {
    $connection = $configuration['datasources']['propel']['connection'];
    $infos = new dbInfos();
    $infos->setUser($connection['user']);
    $infos->setPassword($connection['password']);
    $dsn = $connection['dsn'];
    $matches = array();
    preg_match('/mysql:host=(\w*);dbname=(.*)/', $dsn, $matches);
    $infos->setHost($matches[1]);
    $infos->setName($matches[2]);
    return $infos;
  }

  public static function getDefault()
  {
    $con = Propel::getConfiguration();
    return self::createFromPropelConfiguration($con);
  }


}
