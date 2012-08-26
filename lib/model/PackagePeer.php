<?php


/**
 * Skeleton subclass for performing query and update operations on the 'package' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PackagePeer extends BasePackagePeer {
  public static function retrieveByNameAndIsSource($name, $is_source, PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(PackagePeer::NAME, $name);
    $criteria->add(PackagePeer::IS_SOURCE, $is_source);
    
    $package = PackagePeer::doSelectOne($criteria, $con);
    return $package;
  }
  
/*  
  public static function extractPackageNameFromFilename($filename)
  {
    //strtolower((SUBSTRING(filename, 1, LENGTH(filename) - (LENGTH(SUBSTRING_INDEX(filename, '-', -2))+1))
    if (!preg_match('/^(.+)-[^-]+-[^-]+$/', $filename, $matches))
    {
      throw new PackagePeerException("Could not extract package name from filename : $filename");
    }
    return $matches[1];
  }
*/  
  
  /**
   * 
   * Returns a source package name by various strategies:
   * - SRPM name match
   * - RPM name match
   * - Source package name match
   * - Package name match
   * 
   * then we try again with a stripped name (removing all version and release info)
   * 
   * then if it still doesn't work :
   * - partial SRPM name match (if $partial_match = true)
   * - partial RPM name match (if $partial_match = true)
   * 
   * Then it tries again after stripping versions from the string
   * 
   * @return Package
   */
  public static function retrieveSourcePackageFromString($name, $partial_match = true)
  {
    if ($src_package = self::exact_match($name))
    {
      return $src_package;
    }

    // Else we try to deduce the package name from the string
    if ($src_package = self::exact_match(self::stripVersionFromName($name)))
    {
      return $src_package;
    }
    
    if ($partial_match)
    {
      if ($src_package = self::partial_match($name))
      {
        return $src_package;
      }

      // Else we try to deduce the package name from the string
      if ($src_package = self::partial_match(self::stripVersionFromName($name)))
      {
        return $src_package;
      }
    }
    
    return null;
  }
  
  public static function stripVersionFromName($name)
  {
    // we try to deduce the package name
    // x11-driver-video-ati-6.14.1-4.mga1.src.rpm => x11-driver-video-ati
    $ptemp = explode('-', $name);
    $pkg   = array();
    $pkg[] = $ptemp[0];
    unset($ptemp[0]);
    foreach ($ptemp as $pi) 
    {
      if (is_numeric(substr($pi, 0, 1)))
      {
        break;
      }
      $pkg[] = $pi;
    }
    $pkg = implode('-', $pkg);    
    return $pkg;
  }
  
  /**
   *
   * Returns the closest 
   * 
   */
  public static function exact_match($q)
  {
    // Try to match exact SRPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage();
    }

    // Try to match exact RPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q);
    $criteria->add(RpmPeer::IS_SOURCE, false);
    if ($rpm = RpmPeer::doSelectOne($criteria))
    {
      if ($source_rpm = $rpm->getRpmRelatedBySourceRpmId())
      {
        return $source_rpm->getPackage();
      }
    }
    
    // Try to match a source package name
    if ($source_package = PackagePeer::retrieveByNameAndIsSource($q, true))
    {
      return $source_package;
    }
    
    // Else let's see if it's a non-source package name
    if ($package = PackagePeer::retrieveByNameAndIsSource($q, false))
    {
      // Get its last RPM
      $criteria = new Criteria();
      $criteria->add(RpmPeer::PACKAGE_ID, $package->getId());
      $criteria->addDescendingOrderByColumn(RpmPeer::ID);
      if ($rpm = RpmPeer::doSelectOne($criteria))
      {
        if ($source_rpm = $rpm->getRpmRelatedBySourceRpmId())
        {
          return $source_rpm->getPackage();
        }
      }
    }
    
    return false;
  }
  
  public static function partial_match($q)
  {
    // Else try to match partial SRPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q . "%", Criteria::LIKE);
    $criteria->add(RpmPeer::IS_SOURCE, true);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage();
    }

    // Else try to match partial RPM name
    $criteria = new Criteria();
    $criteria->add(RpmPeer::NAME, $q . "%", Criteria::LIKE);
    $criteria->add(RpmPeer::IS_SOURCE, false);
    if ($source_rpm = RpmPeer::doSelectOne($criteria))
    {
      return $source_rpm->getPackage();
    }
    
    return false;
  }
  
} // PackagePeer
