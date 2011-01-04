<?php 
class distreleaseCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getDefault()
  {
    try
    {
      return DistreleasePeer::getLatest()->getId();
    }
    catch(DistreleasePeerException $e)
    {
      return null;
    }
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
      $unCriterion = $criteria->getNewCriterion(RpmPeer::DISTRELEASE_ID, $val);
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
