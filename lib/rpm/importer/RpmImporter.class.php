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
    try
    {
      $rpmGroup = RpmGroupPeer::retrieveByName($values['group']);
    }
    catch (RpmGroupPeerException $e)
    {
      // a PackagePeerException means there is no such package in database
    }
    if (!isset($rpmGroup))
    {
      $rpmGroup = new RpmGroup();
      $rpmGroup->setName($values['group']);
    }

    // create RPM object
    $rpm = RpmPeer::createFromArray($distrelease, $arch, $media, $rpmGroup, $package, $values);
    
    // save
    $package->save();
    $rpmGroup->save();
    $rpm->save();

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
    
    // update Package object
    // TODO : is_application
    // summary
    // description
    $package->updateSummaryAndDescription();    
    
    // TODO : Process notifications
  }
}