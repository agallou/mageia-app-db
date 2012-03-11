<?php


/**
 * Skeleton subclass for representing a row from the 'rpm' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Rpm extends BaseRpm {
  /**
   * 
   * Search for a binary RPM for which this RPM would be the source RPM
   * Useful only at creation or update time, because you can use the SOURCE_RPM_ID FK otherwise
   * 
   * @return Rpm
   */
  public function inferBinaryRpms()
  {
    $criteria = new Criteria();
    $criteria->add(RpmPeer::DISTRELEASE_ID, $this->getDistrelease()->getId());
    $criteria->add(RpmPeer::ARCH_ID, $this->getArch()->getId());
    $criteria->add(RpmPeer::MEDIA_ID, $this->getMedia()->getId());
    // we match the SOURCE_RPM_NAME with the FILENAME tag (rpm.filename) rather than the real filename (rpm.name)
    // because sometimes the real filename can be wrong
    $criteria->add(RpmPeer::SOURCE_RPM_NAME, $this->getFilename());
    $rpms = RpmPeer::doSelect($criteria);
    return $rpms;
  }    
    
} // Rpm
