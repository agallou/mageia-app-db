<?php


/**
 * Skeleton subclass for performing query and update operations on the 'arch' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ArchPeer extends BaseArchPeer {
  /**
   * Retrieve a single object by name.
   *
   * @param      int $name the name.
   * @param      PropelPDO $con the connection to use
   * @return     Arch
   */
  public static function retrieveByName($name, PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(ArchPeer::NAME, $name);
    
    $archs = ArchPeer::doSelect($criteria, $con);
    
    return !empty($archs) > 0 ? $archs[0] : null;
  }
} // ArchPeer
