<?php


/**
 * Skeleton subclass for representing a row from the 'package' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Package extends BasePackage {
  
  /**
   * 
   * Updates the package summary and description from the package's RPMs
   * 
   */
  public function updateSummaryAndDescription()
  {
    // update package.summary from rpm.summary and package.description from rpm.description
    // The package description is :
    // - the description of the latest corresponding RPM from the distribution (non-backport and non third-party media)
    // - if none found, the description of the latest backport (excluding third-party media)
    // - if none found, the description of the latest RPM for third-party media (excluding backports)
    // - if none found, the description of the latest third-party backport
    // - "LATEST" is measured using the EVR
    $latest_rpm = null;
    
    // non-backports and non-third-party RPMs first
    $criteria = new Criteria();
    $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
    $criteria->add(MediaPeer::IS_BACKPORTS, false);
    $criteria->add(MediaPeer::IS_THIRD_PARTY, false);
    $latest_rpm = $this->getLatestRpm($criteria);
    
    // backports, but non-third party
    if (is_null($latest_rpm))
    {
      $criteria = new Criteria();
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
      $criteria->add(MediaPeer::IS_BACKPORTS, true);
      $criteria->add(MediaPeer::IS_THIRD_PARTY, false);
      $latest_rpm = $this->getLatestRpm($criteria);
    }
    
    // third party media, excluding backports
    if (is_null($latest_rpm))
    {
      $criteria = new Criteria();
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
      $criteria->add(MediaPeer::IS_BACKPORTS, false);
      $criteria->add(MediaPeer::IS_THIRD_PARTY, true);
      $latest_rpm = $this->getLatestRpm($criteria);
    }
    
    // third-party backports
    if (is_null($latest_rpm))
    {
      $criteria = new Criteria();
      $criteria->addJoin(RpmPeer::MEDIA_ID, MediaPeer::ID, Criteria::JOIN);
      $criteria->add(MediaPeer::IS_BACKPORTS, true);
      $criteria->add(MediaPeer::IS_THIRD_PARTY, true);
      $latest_rpm = $this->getLatestRpm($criteria);
    }
    
    if (!is_null($latest_rpm))
    {
      $this->setSummary($latest_rpm->getSummary());
      $this->setDescription($latest_rpm->getDescription());
      $this->save();
    }
    else
    {
      throw new Exception("No RPM found while updating the '" . $this->getName() . "' package");
    }
  }
  
  /**
   * 
   * Returns the latest RPM for this package (using EVR comparison), optionnally filtered by a Criteria
   * Returns null if none found
   * 
   * @param Criteria $criteria
   * 
   * @return Rpm
   */
  protected function getLatestRpm(Criteria $criteria = null)
  {
    $latest_rpm = null;
    $rpms = $this->getRpms($criteria);
    foreach ($rpms as $rpm)
    {
      if (is_null($latest_rpm))
      {
        $latest_rpm = $rpm;
      }
      elseif (RpmPeer::evrCompare($rpm->getEvr(), $latest_rpm->getEvr()) > 0)
      {
        $latest_rpm = $rpm;
      }
    }    
    return $latest_rpm;
  }
} // Package
