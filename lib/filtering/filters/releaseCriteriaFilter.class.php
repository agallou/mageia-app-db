<?php 
class releaseCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }


  /**
   * @return int|null
   */
  public function getDefault()
  {
    $default = new releaseDefault();
    return $default->getDefault();
  }

  public function getValues()
  {
    $criteria = new Criteria();
    $criteria->addDescendingOrderByColumn(DistreleasePeer::NAME);
    $distreleases = DistreleasePeer::doSelect($criteria);
    $values = array();
    // Devel release(s) first
    foreach ($distreleases as $distrelease)
    {
      if ($distrelease->getIsDevVersion())
      {
        $values[$distrelease->getName()] = $distrelease->getName();
      }
    }
    
    // Meta releases
    $meta_latest = DistreleasePeer::getMetaLatest();
    $meta_previous = DistreleasePeer::getMetaPrevious();
    $values[DistreleasePeer::META_LATEST] = $meta_latest->getDisplayedName();
    $values[DistreleasePeer::META_PREVIOUS] = $meta_previous->getDisplayedName();
    
    // Latest and previous
    if ($latest = DistreleasePeer::getLatest())
    {
      $values[$latest->getName()] = $latest->getDisplayedName();
    }
    if ($previous = DistreleasePeer::getPrevious())
    {
      $values[$previous->getName()] = $previous->getDisplayedName();
    }
    
    // Then descending order by
    foreach ($distreleases as $distrelease)
    {
      if (!array_key_exists($distrelease->getName(), $values))
      {
        $values[$distrelease->getName()] = $distrelease->getDisplayedName();
      }
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
      $distrelease = DistreleasePeer::retrieveByName($val);
      if (!$distrelease)
      {
        throw new baseCriteriaFilterException("Unknown value '$val' for filter '".$this->getCode()."'");
      }
      // Replace meta distrelease with actual distrelease
      if ($distrelease->getIsMeta())
      {
        $distrelease = $distrelease->getRealDistrelease();
      }
      
      if ($distrelease)
      {
        $unCriterion = $criteria->getNewCriterion(RpmPeer::DISTRELEASE_ID, $distrelease->getId());
      }
      else
      {
        // no distrelease, make it so that is gives no result
        $unCriterion = $criteria->getNewCriterion(null, "1=2", Criteria::CUSTOM);
      }
      
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
    return 'release';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Distribution'; //Internationalisation ? outside, allways in english here.
  }

}
