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
    // TODO : unit-test this function
    $split_evr1 = self::evrSplit($evr1);
    $split_evr2 = self::evrSplit($evr2);
    
    // epoch
    if (version_compare($split_evr1[0], $split_evr2[0], '>'))
    {
      return 1;
    }
    elseif (version_compare($split_evr1[0], $split_evr2[0], '<'))
    {
      return -1;
    }
    else
    {
      // version
      if (version_compare($split_evr1[1], $split_evr2[1], '>'))
      {
        return 1;
      }
      elseif (version_compare($split_evr1[1], $split_evr2[1], '<'))
      {
        return -1;
      }
      else 
      {
        // release
        if (version_compare($split_evr1[2], $split_evr2[2], '>'))
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
    }
  }
  
  /**
   * 
   * Returns array($epoch, $version, $release)
   * 
   * @param string $evr
   */
  public static function evrSplit($evr)
  {
    // TODO : unit-test this function
    $tab = explode(':', $evr);
    $epoch = count($tab) > 1 ? $tab[0] : 0;
    $vr = count($tab) > 1 ? $tab[1] : $evr;
    
    list($version, $release) = explode('-', $vr);
    
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
