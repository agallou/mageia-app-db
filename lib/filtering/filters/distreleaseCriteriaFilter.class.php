<?php 
class distreleaseCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getValues()
  {
    $criteria = new Criteria();
    $distreleases = DistreleasePeer::doSelect($criteria);
    $values = array();
    foreach ($distreleases as $distrelease)
    {
      $values[$distrelease->getId()] = $distrelease->getName();
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
    $value = $this->getValueFromContext($context);
    //TODO liste avec opérandes ????
    //plusieurs fois le même parameterHolder ??? pas de context ???
    if (count($value))
    {
      $criterion = null;
    //  $criteria->addJoin(PackagePeer::ID, RpmPeer::PACKAGE_ID, Criteria::JOIN);
      $criteria->addJoin(RpmPeer::DISTRELEASE_ID, DistreleasePeer::ID, Criteria::JOIN);
      foreach ($value as $val)
      {
        $unCriterion = $criteria->getNewCriterion(DistreleasePeer::ID, $val);
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
    return 'distrelease';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Release'; //Internationalisation ? outside, allways in english here.
  }

}
