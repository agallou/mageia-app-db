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
echo ($compare);    
    if ($compare == 0)
    {
      $compare = DistreleasePeer::compare($rpm1->getDistrelease(), $rpm2->getDistrelease());
    }
    return($compare);
  }
  
  
  public static function sortByEvrAndDistrelease($rpms, $descending=true)
  {
    usort($rpms, 'self::rpmEvrAndDistreleaseCompare');
    if ($descending) 
    {
      $rpms = array_reverse($rpms);
    }
    return $rpms;
  }
  
} // RpmPeer
