<?php


/**
 * Skeleton subclass for performing query and update operations on the 'rpm_group' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class RpmGroupPeer extends BaseRpmGroupPeer {

  /**
   * 
   * Returns an array of RpmGroup containing RpmGroups whose name match $pattern
   *
   * @param string $pattern
   * 
   */
  public static function getGroupsWhereNameLike($pattern)
  {
    $criteria = new Criteria();
    $criteria->add(RpmGroupPeer::NAME, $pattern, Criteria::LIKE);
    return RpmGroupPeer::doSelect($criteria);
  }
  
  
  /**
   * 
   * Returns an array of RpmGroup containing RpmGroups whose name match $pattern
   *
   * @param string $pattern
   */
  public static function getGroupsIdsWhereNameLike($pattern)
  {
    $results = array();
    foreach (self::getGroupsWhereNameLike($pattern) as $rpm_group)
    {
      $results[] = $rpm_group->getId();
    }
    return $results;
  }
} // RpmGroupPeer
