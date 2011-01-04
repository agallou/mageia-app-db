<?php 
class applicationCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::PACKAGE;
  }

  public function getDefault()
  {
    return 1;
  }

  public function getValues()
  {
    return array(
      '1' => 'Yes',
      '0' => 'No',
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
