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

  public static function getLatest()
  {
    $criteria = new Criteria();
    $criteria->add(DistreleasePeer::IS_LATEST, true);
    $distrelease = DistreleasePeer::doSelectOne($criteria);
    if (null === $distrelease)
    {
      throw new DistreleasePeerException('lastest distrelease not found');
    }
    return $distrelease;
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
    
    if (null === $distrelease) 
    { 
      throw new DistreleasePeerException('Distrelease \'' . $name . '\' not found (by name)'); 
    }
    
    return $distrelease;
  }

} // DistreleasePeer
