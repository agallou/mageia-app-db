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
    $split_evr1[0] = is_null($split_evr1[0]) ? 0 : $split_evr1[0];
    $split_evr2[0] = is_null($split_evr2[0]) ? 0 : $split_evr2[0];
    $comparison = self::compareVersions($split_evr1[0], $split_evr2[0]);
    if ($comparison != 0)
    {
      return $comparison;
    }

    // version
    $comparison = self::compareVersions($split_evr1[1], $split_evr2[1]);
    if ($comparison != 0)
    {
      return $comparison;
    }

    // release
    if (is_null($split_evr1[2]) or is_null($split_evr2[2]))
    {
      if (!is_null($split_evr1[2])) 
      {
        return 1;
      }
      elseif (!is_null($split_evr2[2]))
      {
        return -1;
      }
      else // both null
      {
        return 0;
      }
    }    
    else
    {
      return self::compareVersions($split_evr1[2], $split_evr2[2]);
    }
  }
  
  public static function compareVersions($first, $second)
  {
    if ($first === $second)
    {
      return 0;
    }
    
    $tab1 = explode('.', $first);
    $tab2 = explode('.', $second);
    
    foreach ($tab1 as $key => $value)
    {
      if (!isset($tab2[$key]))
      {
        return 1;
      }
      
      $comparison = self::compareItems($value, $tab2[$key]);
      if ($comparison != 0)
      {
        return $comparison;
      }
    }
    
    if (count($tab1) > count($tab2))
    {
      return 1;
    }
    if (count($tab1) < count($tab2))
    {
      return -1;
    }
    
    return 0;
  }
  
  /**
   * compares 2 items, for example the 2RC4 from 3.2RC4 with the 2 from 3.2
   * 2 > 2RC4
   * 2 > 2[A-Za-z_][A-Za-z0-9_]*
   */
  public static function compareItems($first, $second)
  {
    $matches = array();
    preg_match('/([0-9]+)([A-Za-z_][A-Za-z0-9_]*)?/', $first, $matches);
    $number1 = $matches[1];
    $rest1 = isset($matches[2]) ? $matches[2] : null;

    $matches = array();
    preg_match('/([0-9]+)([A-Za-z_][A-Za-z0-9_]*)?/', $second, $matches);
    $number2 = $matches[1];
    $rest2 = isset($matches[2]) ? $matches[2] : null;
    
    if ($number1 > $number2)
    {
      return 1;
    }
    elseif ($number1 < $number2)
    {
      return -1;
    }
    elseif ($rest1 === $rest2)
    {
      return 0;
    }
    // no rest is higher than some rest
    elseif ($rest1 === null and $rest2 !== null)
    {
      return 1;
    }
    elseif ($rest1 !== null and $rest2 === null)
    {
      return -1;
    }
    elseif ($rest1 > $rest2)
    {
      return 1;
    }
    else
    {
      return -1;
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

    $description = str_replace('\n', "\n", $values['description']);
    // Fix bad encoding in Sophie's response
    $description = mb_convert_encoding($description, 'latin1', 'utf-8');
    $summary = mb_convert_encoding($values['summary'], 'latin1', 'utf-8');
    $rpm->setDescription($description);
    $rpm->setSummary($summary);
    
    $rpm->setEvr($values['evr']);
    $rpm->setLicense($values['license']);
    $rpm->setName($values['real_filename']);
    $rpm->setMd5Name(md5($values['real_filename']));
    $rpm->setFilename($values['filename']);
    $rpm->setRealarch($values['arch']);
    $rpm->setRelease($release);
    $rpm->setIsSource(self::inferIsSourceFromFilename($values['filename']));
    $rpm->setRpmPkgid($values['pkgid']);
    
    $rpm->setShortName($package->getName());
    $rpm->setSize($values['size']);
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
  
  /**
   * 
   * Retrieve a list of SRPMs for a given bug number
   * 
   * @param $bugnum       the bug number
   * @param $match_types  array. List of values for rpm.bug_match_type. Not used if null.
   * @param $arch         arch name. Not used if null.
   * 
   * @return array Array of selected Objects
   */
  public static function retrieveByBugNumber($bugnum, $match_types = null, $arch = null)
  {
    $criteria = new Criteria();
    $criteria->add(RpmPeer::BUG_NUMBER, $bugnum);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if (!is_null($match_types))
    {
      $criteria->add(RpmPeer::BUG_MATCH_TYPE, $match_types, Criteria::IN);
    }
    if (!is_null($arch))
    {
      $criteria->addJoin(RpmPeer::ARCH_ID, ArchPeer::ID);
      $criteria->add(ArchPeer::NAME, $arch);
    }
    
    $criteria->addAscendingOrderByColumn(RpmPeer::NAME);
    $rpms = RpmPeer::doSelect($criteria);
    return $rpms;
  }

} // RpmPeer
