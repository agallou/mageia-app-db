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
    $groups = RpmGroupPeer::doSelect(new Criteria);
    //TODO some callback to a statement.
    foreach ($groups as $group)
    {
      $values[$group->getId()] = $group->getName();
    }
    return $values;
  }

  /**
   * filter 
   * 
   * @param Criteria             $criteria 
   * @param iMadbParameterHolder $parameterHolder 

   * @return Criteria
   */
  protected function filter(Criteria $criteria, madbContext $context)
  {
    //TODO liste avec opérandes ????
    //plusieurs fois le même parameterHolder ??? pas de context ???
    $value = $context->getParameter('group');
    if (null !== $value)
    { 
      $value = explode(',', $value);
      $criteria->addAnd(RpmPeer::RPM_GROUP_ID, $value, Criteria::IN);
    }
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
