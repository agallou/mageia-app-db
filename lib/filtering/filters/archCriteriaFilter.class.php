<?php 
class archCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getValues()
  {
    $values = array();
    $archs = ArchPeer::doSelect(new Criteria);
    //TODO some callback to a statement.
    foreach ($archs as $arch)
    {
      $values[$arch->getId()] = $arch->getName();
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
    $value = $context->getParameter('arch');
    if (null !== $value)
    { 
      $value = explode(',', $value);
      $criteria->addAnd(RpmPeer::ARCH_ID, $value, Criteria::IN);
    }
    return $criteria;
  }

  public function getCode()
  {
    return 'arch';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Arch'; //Internationalisation ? outside, allways in english here.
  }

}
