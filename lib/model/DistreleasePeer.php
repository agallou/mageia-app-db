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
      throw new sfException('lastest distrelease not found');
    }
    return $distrelease;
  }

} // DistreleasePeer
