<?php
class RpmImporter
{
  /**
   * 
   * Insert RPM in database and update related tables
   * 
   * @param Distrelease $distrelease
   * @param Arch $arch
   * @param Media $media
   * @param array $values
   */
  public function importFromArray(Distrelease $distrelease, Arch $arch, Media $media, $values)
  {
$startTime = microtime(true);
echo " (";
    // Is it a source RPM ?
    $is_source = RpmPeer::inferIsSourceFromFilename($values['filename']);
    
    // Create Package object if doesn't exist and save it, else retrieve it
    $package_name = $values['name'];
    $package = PackagePeer::retrieveByNameAndIsSource($package_name, $is_source);
    if ($package === null)
    {
      $package = new Package();
      $package->setName($package_name);
      $package->setIsSource($is_source);
      $package->setSummary($values['summary']);
      $package->setDescription($values['description']);
      // TODO : $package->setIsApplication();
      $package->setMd5Name(md5($package_name));
    }
    // Create RpmGroup object if doesn't exist and save it, else retrieve it
    $rpmGroup = RpmGroupPeer::retrieveByName($values['group']);
    if ($rpmGroup === null)
    {
      $rpmGroup = new RpmGroup();
      $rpmGroup->setName($values['group']);
    }
echo round(microtime(true) - $startTime, 2) . ", ";    
    
    // create RPM object
    $rpm = RpmPeer::createFromArray($distrelease, $arch, $media, $rpmGroup, $package, $values);
echo round(microtime(true) - $startTime, 2) . ", ";    
    
    // save
    if ($package->isNew())
    {
      $package->save();
    }
echo round(microtime(true) - $startTime, 2) . ", ";    
    if ($rpmGroup->isNew())
    {
      $rpmGroup->save();
    }
echo round(microtime(true) - $startTime, 2) . ", ";    
    $rpm->save();
echo round(microtime(true) - $startTime, 2) . ", ";    
    
    // If it's a source RPM, update the relationship with its binary RPM, if present in database
    if ($rpm->getIsSource())
    {
      if ($binary_rpms = $rpm->inferBinaryRpms())
      {
        foreach ($binary_rpms as $binary_rpm)
        {
          $binary_rpm->setRpmRelatedBySourceRpmId($rpm);
          $binary_rpm->save();
        }
      }
    }
echo round(microtime(true) - $startTime, 3) . ", ";    
    
    // update Package object
    // TODO : is_application
    // summary
    // description
    $package->updateSummaryAndDescription();    
echo round(microtime(true) - $startTime, 3) . ")";    
    
    // TODO : Process notifications
    if (isset($binary_rpms))
    {
      foreach ($binary_rpms as $binary_rpm)
      {
        $binary_rpm->clearAllReferences(true);
      }
    }
    $rpmGroup->clearAllReferences(true);
    $package->clearAllReferences(true);
    $rpm->clearAllReferences(true);
  }
}