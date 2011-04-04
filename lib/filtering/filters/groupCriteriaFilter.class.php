<?php 
class groupCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getValues()
  {
    $values = array();
    $criteria = new Criteria();
    $criteria->addAscendingOrderByColumn(RpmGroupPeer::NAME);
    $groups = RpmGroupPeer::doSelect($criteria);
    //TODO some callback to a statement.
    foreach ($groups as $group)
    {
      $values[$group->getId()] = $group->getName();
    }
    return $values;
  }

  /**
   * doFilterChoice 
   * 
   * @param Criteria             $criteria 
   * @param                      $value 
   * @return Criteria
   */
  protected function doFilterChoice(Criteria $criteria, $value)
  {
    $criteria->addAnd(RpmPeer::RPM_GROUP_ID, $value, Criteria::IN);
    return $criteria;
  }

  public function getCode()
  {
    return 'group';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Group'; //Internationalisation ? outside, allways in english here.
  }

}
