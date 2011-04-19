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
   * Retrieve a single object by name.
   *
   * @param      int $name the name.
   * @param      PropelPDO $con the connection to use
   * @return     RpmGroup
   */
  public static function retrieveByName($name, PropelPDO $con = null)
  {
    $criteria = new Criteria();
    $criteria->add(RpmGroupPeer::NAME, $name);
    
    $rpmGroup = RpmGroupPeer::doSelectOne($criteria, $con);
    return $rpmGroup;
  }  
  
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
   * Returns the list of child group ids whose name begins with $parent_name
   * If $include_parent is true, returns also the parent group if it exists
   *
   * @param string $parent_name
   * @param bool $include_parent
   */
  public static function getChildGroupsFor($parent_name, $include_parent = false, $include_children = true)
  {
    $results = array();
    if ($include_parent and $rpm_group = self::retrieveByName($parent_name))
    {
      $results[] = $rpm_group->getId();
    }
    if ($include_children)
    {
      foreach (self::getGroupsWhereNameLike($parent_name . '/%') as $rpm_group)
      {
        $results[] = $rpm_group->getId();
      }
    }
    return $results;
  }
} // RpmGroupPeer
