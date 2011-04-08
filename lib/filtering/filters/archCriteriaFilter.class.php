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
      return $archs[0]->getId();
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
        $values[$arch->getId()] = $arch->getName();
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
    $criteria->addAnd(RpmPeer::ARCH_ID, $value, Criteria::IN);
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
