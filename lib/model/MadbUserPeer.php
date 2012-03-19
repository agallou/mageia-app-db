<?php


/**
 * Skeleton subclass for performing query and update operations on the 'madb_user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class MadbUserPeer extends BaseMadbUserPeer {

  public static function retrieveByLogin($login)
  {
    $criteria = new Criteria();
    $criteria->add(MadbUserPeer::LOGIN, $login);
    return MadbUserPeer::doSelectOne($criteria);
  }


} // MadbUserPeer
