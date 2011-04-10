<?php 
class sourceCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getDefault()
  {
    return 0;
  }

  public function getValues()
  {
    return array(
      '0' => 'regular packages',
      '1' => 'source packages',
    );
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
    return 'Regular/Source'; //Internationalisation ? outside, allways in english here.
  }

}
