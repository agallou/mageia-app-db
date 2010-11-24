<?php 
class applicationCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::PACKAGE;
  }

  public function getValues()
  {
    return array(
      '1' => 'Oui',
      '0' => 'Non',
    );
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
    $value = $context->getParameter('application');
    if (null !== $value && $value != '_no_')
    {
      $criteria->addAnd(PackagePeer::IS_APPLICATION, $value);
    }
    return $criteria;
  }

  public function getCode()
  {
    return 'application';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Type'; //Internationalisation ? outside, allways in english here.
  }

}
