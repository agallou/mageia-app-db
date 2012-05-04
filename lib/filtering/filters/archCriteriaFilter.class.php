<?php 
class archCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getDefault()
  {
    $archs = ArchPeer::listByNameLike('i_86');
    if (!empty($archs))
    {
      return $archs[0]->getName();
    }
    else
    {
      return ArchPeer::doSelectOne(new Criteria());
    }
  }

  public function getValues()
  {
    $values = array();
    if ($archs = ArchPeer::doSelect(new Criteria))
    {
      //TODO some callback to a statement.
      foreach ($archs as $arch)
      {
        $values[$arch->getName()] = $arch->getName();
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
      $arch = ArchPeer::retrieveByName($val);
      if (!$arch)
      {
        throw new baseCriteriaFilterException("Unknown value '$val' for filter '".$this->getCode()."'");
      }
      $unCriterion = $criteria->getNewCriterion(RpmPeer::ARCH_ID, $arch->getId());
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
