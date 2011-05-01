<?php
class RpmImporter
{
    /**
     * This var holds bool, thereever to enable notifications of user or not
     * @var bool 
     */
    var $notify;

    public function  __construct($notify) {
        $this->notify = $notify;
    }
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
      // TODO : $package->setIsApplication(); => no, treated outside
      $package->setMd5Name(md5($package_name));
    }
    
    // Create RpmGroup object if doesn't exist and save it, else retrieve it
    $rpmGroup = RpmGroupPeer::retrieveByName($values['group']);
    if ($rpmGroup === null)
    {
      $rpmGroup = new RpmGroup();
      $rpmGroup->setName($values['group']);
    }
    
    // create RPM object
    $rpm = RpmPeer::createFromArray($distrelease, $arch, $media, $rpmGroup, $package, $values);
    
    // save
    if ($package->isNew())
    {
      $package->save();
    }
    if ($rpmGroup->isNew())
    {
      $rpmGroup->save();
    }
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
    // summary
    // description
    $package->updateSummaryAndDescription();    
    

     // trigger rpm event to send notifications
    // trigger user notifications only if it is enabled
    if($this->notify)
    {
	// we mean that if media is updates and it isn't testing branch it always updates
	// but rpm's added to core media and etc is updates too
	// TODO: is core updates just updates and not update candidates?
	// just uncomment next line if you feel there is no need to notify about core updates
        /*if($media->getIsUpdates()   && !$media->getIsTesting())*/
	$event = NotificationEvent::UPDATE;
        if($media->getIsUpdates()   &&  $media->getIsTesting()) $event = NotificationEvent::UPDATE_CANDIDATE;
        if($media->getIsBackports() && !$media->getIsTesting()) $event = NotificationEvent::NEW_VERSION;
        if($media->getIsBackports() &&  $media->getIsTesting()) $event = NotificationEvent::NEW_VERSION_CANDIDATE;
        sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent($rpm,"rpm.import",array(
            'event' => $event
    )));
    }

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
    $distrelease->clearAllReferences(true);
    $arch->clearAllReferences(true);
    $media->clearAllReferences(true);
  }
}