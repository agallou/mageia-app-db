<?php 
class sourceCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getValues()
  {
    return array(
      '0' => 'regular packages',
      '1' => 'source packages',
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
    $value = $this->getValueFromContext($context);
    //TODO liste avec opérandes ????
    //plusieurs fois le même parameterHolder ??? pas de context ???
    if (count($value))
    {
      $criterion = null;
      foreach ($value as $val)
      {
        $unCriterion = $criteria->getNewCriterion(RpmPeer::IS_SOURCE, $val);
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
    return 'source';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Source'; //Internationalisation ? outside, allways in english here.
  }

}
