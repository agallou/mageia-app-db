<?php


/**
 * Skeleton subclass for performing query and update operations on the 'distrelease' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class DistreleasePeer extends BaseDistreleasePeer {

  const META_LATEST = 'latest';
  const META_PREVIOUS = 'previous';
    
  public static function getLatest()
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_LATEST, true);
    $distrelease = DistreleasePeer::doSelectOne($criteria);
    return $distrelease;
  }

  public static function getMetaLatest()
  {
    return self::retrieveByName(self::META_LATEST);
  }

  public static function getPrevious()
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_PREVIOUS, true);
    $distrelease = DistreleasePeer::doSelectOne($criteria);
    return $distrelease;
  }

  public static function getMetaPrevious()
  {
    return self::retrieveByName(self::META_PREVIOUS);
  }

  public static function getDevels()
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_DEV_VERSION, true);
    $distreleases = DistreleasePeer::doSelect($criteria);
    return $distreleases;
  }  

  /**
   * returns a the first devel distrelease it finds, or none
   * 
   * @return Distrelease 
   */
  public static function getDevel()
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_DEV_VERSION, true);
    $criteria->addAscendingOrderByColumn(DistreleasePeer::ID);
    return DistreleasePeer::doSelectOne($criteria);
  }
  
  /**
   * 
   * Compares 2 distreleases :
   * Returns : 1 if $distrelease1 is more recent than $distrelease2, 0 if equal, -1 otherwise
   * 
   * @param Distrelease $distrelease1
   * @param Distrelease $distrelease2
   */
  public static function compare(Distrelease $distrelease1, Distrelease $distrelease2)
  {
    // TODO : better comparison, because name comparison will not always work
    if ($distrelease1->getName() > $distrelease2->getName()) return 1;
    if ($distrelease1->getName() < $distrelease2->getName()) return -1;
    return 0;
  }
  
  /**
   * Retrieve a single object by name.
   *
   * @param      int $name the name.
   * @param      PropelPDO $con the connection to use
   * @return     Distrelease
   */
  public static function retrieveByName($name, PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::NAME, $name);
    
    $distrelease = DistreleasePeer::doSelectOne($criteria, $con);
    return $distrelease;
  }
  
  public static function updateIsLatestFlag($name)
  {
    if (!$new_latest_stable = self::retrieveByName($name))
    {
      throw new DistreleasePeerException("Latest stable release '$name' not found in database");
    }
    
    // If the distrelease doesn't already know it's the latest stable release
    if (!$new_latest_stable->getIsLatest())
    {
      // unset the flag to the old stable release, if there is one
      if ($old_latest_stable = self::getLatest())
      {
        $old_latest_stable->setIsLatest(false);
        $old_latest_stable->save();
      }
      
      // set the flag to the new one
      $new_latest_stable->setIsLatest(true);
      $new_latest_stable->save();
    }
  }
  
  public static function updateIsPreviousFlag($name)
  {
    if (!is_null($name) and !$new_previous_stable = self::retrieveByName($name))
    {
      throw new DistreleasePeerException("Previous stable release '$name' not found in database");
    }
    else
    {
      // unset the flag to the old previous stable release, if there is one
      $old_previous_stable = self::getPrevious();
      if ($old_previous_stable)
      {
        $old_previous_stable->setIsPrevious(false);
        $old_previous_stable->save();
      }
      
      // If the distrelease doesn't already know it's the previous stable release
      if (!is_null($name) and !$new_previous_stable->getIsPrevious())
      {
        // set the flag to the new one
        $new_previous_stable->setIsPrevious(true);
        $new_previous_stable->save();
      }
    }
  }
  
} // DistreleasePeer
