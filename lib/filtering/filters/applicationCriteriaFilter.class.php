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
      '1' => 'Show only applications',
      '0' => 'Show all packages',
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
      if ($val == 1)
      {
        $unCriterion = $criteria->getNewCriterion(PackagePeer::IS_APPLICATION, true);
        if (is_null($criterion))
        {
          $criterion = $unCriterion;
        }
        else
        {
          $criterion->addOr($unCriterion);
        }
      }
    }
    if (!is_null($criterion))
    {
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
    return 'Applications'; //Internationalisation ? outside, allways in english here.
  }

}
