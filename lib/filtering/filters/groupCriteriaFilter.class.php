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
      $criteriaOrig = $criteria;
      $criteria = clone $criteria;
      $criteria->clearSelectColumns();
      $criteria->addSelectColumn(PackagePeer::ID);
      $criteria->addJoin(PackagePeer::ID, RpmPeer::PACKAGE_ID, Criteria::JOIN);
      $criteria->addJoin(RpmPeer::RPM_GROUP_ID, RpmGroupPeer::ID, Criteria::JOIN);
      $criteria->addAnd(RpmGroupPeer::ID, $value);

      $toTmp = new criteriaToTemporaryTable($criteria, 'tmp_filtrage');
      $toTmp->setConnection(Propel::getConnection());
      $toTmp->execute();

      $criteria = $criteriaOrig;
      $criteria->addJoin(PackagePeer::ID, $toTmp->getField('id'), Criteria::JOIN);
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
