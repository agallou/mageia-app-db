<?php


/**
 * Skeleton subclass for performing query and update operations on the 'media' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class MediaPeer extends BaseMediaPeer {
  /**
   * Retrieve a single object by name.
   *
   * @param      int $name the name.
   * @param      PropelPDO $con the connection to use
   * @return     Media
   */
  public static function retrieveByName($name, PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(MediaPeer::NAME, $name);
    
    $media = MediaPeer::doSelectOne($criteria, $con);
    return $media;
  }
} // MediaPeer
