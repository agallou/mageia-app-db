<?php


/**
 * Skeleton subclass for representing a row from the 'madb_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class MadbUser extends BaseMadbUser {

  public function checkPassword($username, $password, PluginsfGuardUser $user)
  {
    $madbConnectorFactory = new madbUserConnectorFactory($this, $user, $username, $password);
    $madbConnector        = $madbConnectorFactory->create(sfConfig::get('app_user_connector'));
    return $madbConnector->checkPassword();
  }
} // MadbUser
