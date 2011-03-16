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
    
    $medias = MediaPeer::doSelectOne($criteria, $con);
    return $medias;
  }
  
  /**
   * 
   * retrieve all updates medias
   * 
   * @return Media
   */
  public static function getUpdatesMedias()
  {
    $criteria = new Criteria();
    $criteria->add(MediaPeer::IS_UPDATES, true);
    
    $medias = MediaPeer::doSelect($criteria);
    return $medias;
  }
  
  /**
   * 
   * retrieve all testing medias
   * 
   * @return Media
   */
  public static function getTestingMedias()
  {
    $criteria = new Criteria();
    $criteria->add(MediaPeer::IS_TESTING, true);
    
    $medias = MediaPeer::doSelect($criteria);
    return $medias;
  }
  
  /**
   * 
   * retrieve all backports medias
   * 
   * @return Media
   */
  public static function getBackportsMedias()
  {
    $criteria = new Criteria();
    $criteria->add(MediaPeer::IS_BACKPORTS, true);
    
    $medias = MediaPeer::doSelect($criteria);
    return $medias;
  }
  
  /**
   * 
   * retrieve all 3rd party medias
   * 
   * @return Media
   */
  public static function getThirdPartyMedias()
  {
    $criteria = new Criteria();
    $criteria->add(MediaPeer::IS_THIRD_PARTY, true);
    
    $medias = MediaPeer::doSelect($criteria);
    return $medias;
  }
  
  /**
   * 
   * Convert an array of Media to array of names
   * 
   * @param array array of Media
   * @return array array of strings
   */
  public static function MediasToNames($medias)
  {
    $names = array();
    foreach ($medias as $media)
    {
      $names[] = $media->getName();
    }
    return $names;
  }
} // MediaPeer
