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
    if (null !== $value)
    {
      $value = explode(',', $value);
      $criterion = null;
      foreach ($value as $val)
      {
        $unCriterion = $criteria->getNewCriterion(PackagePeer::IS_APPLICATION, (bool)$val);
        if (is_null($criterion))
        {
          $criterion = $unCriterion;
        }
        else
        {
          $criterion->addOr($unCriterion);
        }
      }
      $criteria->addAnd($criterion);
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
