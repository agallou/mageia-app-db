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
} // PackagePeer
