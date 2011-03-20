<?php


/**
 * Skeleton subclass for performing query and update operations on the 'rpm' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class RpmPeer extends BaseRpmPeer {
  
  /**
   * 
   * Returns 1 if $evr1 is bigger than $evr2
   * Returns -1 if $evr1 is smaller than $evr2
   * Returns 0 if they are equal
   * 
   * @param string $evr1
   * @param string $evr2
   */
  public static function evrCompare($evr1, $evr2)
  {
    $split_evr1 = self::evrSplit($evr1);
    $split_evr2 = self::evrSplit($evr2);
    
    // epoch
    if (is_null($split_evr1[0]) or is_null($split_evr2[0]))
    {
      if (!is_null($split_evr1[0])) 
      {
        return 1;
      }
      if (!is_null($split_evr2[0]))
      {
        return -1;
      }
    }
    elseif (version_compare($split_evr1[0], $split_evr2[0], '>'))
    {
      return 1;
    }
    elseif (version_compare($split_evr1[0], $split_evr2[0], '<'))
    {
      return -1;
    }


    // version
    if (version_compare($split_evr1[1], $split_evr2[1], '>'))
    {
      return 1;
    }
    elseif (version_compare($split_evr1[1], $split_evr2[1], '<'))
    {
      return -1;
    }

    // release
    if (is_null($split_evr1[2]) or is_null($split_evr2[2]))
    {
      if (!is_null($split_evr1[2])) 
      {
        return 1;
      }
      if (!is_null($split_evr2[2]))
      {
        return -1;
      }
    }    
    elseif (version_compare($split_evr1[2], $split_evr2[2], '>'))
    {
      return 1;
    }
    elseif (version_compare($split_evr1[2], $split_evr2[2], '<'))
    {
      return -1;
    }
    else 
    {
      return 0;
    }
  }
  
  /**
   * 
   * Returns array($epoch, $version, $release)
   * $epoch and $release may be null
   * 
   * @param string $evr
   */
  public static function evrSplit($evr)
  {
    $tab = explode(':', $evr);
    $epoch = count($tab) > 1 ? $tab[0] : null;
    $vr = count($tab) > 1 ? $tab[1] : $evr;

    $tab2 = explode('-', $vr);
    $version = $tab2[0];
    $release = (isset($tab2[1])) ? $tab2[1] : null;
    
    return array($epoch, $version, $release);
  }
  
  /**
   * 
   * Compares 2 RPMs using RpmPeer::evrCompare
   * 
   * @param string $rpm1
   * @param string $rpm2
   */
  public static function rpmEvrAndDistreleaseCompare($rpm1, $rpm2)
  {
    $compare = self::evrCompare($rpm1->getEvr(), $rpm2->getEvr());
    if ($compare == 0)
    {
      $compare = DistreleasePeer::compare($rpm1->getDistrelease(), $rpm2->getDistrelease());
    }
    return($compare);
  }
  
  
  public static function sortByEvrAndDistrelease($rpms, $descending=true)
  {
    usort($rpms, array('RpmPeer', 'rpmEvrAndDistreleaseCompare'));
    if ($descending) 
    {
      $rpms = array_reverse($rpms);
    }
    return $rpms;
  }
  
  public static function inferIsSourceFromFilename($filename)
  {
    return preg_match('/^.*\.src\.rpm$/i', $filename);
  }
  
  public static function retrieveUniqueByName(Distrelease $distrelease, Arch $arch, Media $media, $name)
  {
    $criteria = new Criteria();
    $criteria->add(RpmPeer::DISTRELEASE_ID, $distrelease->getId());
    $criteria->add(RpmPeer::ARCH_ID, $arch->getId());
    $criteria->add(RpmPeer::MEDIA_ID, $media->getId());
    $criteria->add(RpmPeer::NAME, $name);
    $rpm = RpmPeer::doSelectOne($criteria);
    return $rpm;
  }
  
  
  /**
   * 
   * Create a Rpm object from an array of values and related objects
   * 
   * @param Distrelease $distrelease
   * @param Arch $arch
   * @param Media $media
   * @param RpmGroup $rpmGroup
   * @param Package $package
   * @param array $values
   * @throws RpmPeerException
   * @return Rpm
   */
  public static function createFromArray(Distrelease $distrelease, Arch $arch, Media $media, RpmGroup $rpmGroup, Package $package, $values)
  {
    list ($epoch, $version, $release) = self::evrSplit($values['evr']);
    $rpm = new Rpm();
    
    $rpm->setDistrelease($distrelease);
    $rpm->setArch($arch);
    $rpm->setMedia($media);
    $rpm->setPackage($package);
    $rpm->setRpmGroup($rpmGroup);
    
    $rpm->setBuildTime($values['buildtime']);
    $rpm->setDescription($values['description']);
    $rpm->setEvr($values['evr']);
    $rpm->setLicence($values['license']);
    $rpm->setName($values['real_filename']);
    $rpm->setMd5Name(md5($values['real_filename']));
    $rpm->setFilename($values['filename']);
    $rpm->setRealarch($values['arch']);
    $rpm->setRelease($release);
    $rpm->setIsSource(self::inferIsSourceFromFilename($values['filename']));
    $rpm->setRpmPkgid($values['pkgid']);
    
    $rpm->setShortName($package->getName());
    $rpm->setSize($values['size']);
    $rpm->setSummary($values['summary']);
    $rpm->setUrl(isset($values['url']) ? $values['url'] : '');
    $rpm->setVersion($epoch === null ? $version : "$epoch:$version");
    
    // Find the source RPM if it's in database and add the relationship with it
    if (!$rpm->getIsSource())
    {
      if (isset($values['sourcerpm']))
      {
        $rpm->setSourceRpmName($values['sourcerpm']);
        if ($source_rpm = self::retrieveUniqueByName($distrelease, $arch, $media, $values['sourcerpm']))
        {
          $rpm->setRpmRelatedBySourceRpmId($source_rpm);
        }
      }
    }
    
    return $rpm;
  }
} // RpmPeer
