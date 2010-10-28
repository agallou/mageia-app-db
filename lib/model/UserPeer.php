<?php


/**
 * Skeleton subclass for performing query and update operations on the 'user' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class UserPeer extends BaseUserPeer {

  public static function retrieveByLogin($login)
  {
    $criteria = new Criteria();
    $criteria->add(UserPeer::LOGIN, $login);
    return UserPeer::doSelectOne($criteria);
  }


} // UserPeer
