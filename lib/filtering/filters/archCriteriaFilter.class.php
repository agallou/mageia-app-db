<?php 
class archCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::RPM;
  }

  public function getDefault()
  {
    try
    {
      return ArchPeer::retrieveByName('i586')->getId();
    }
    catch(ArchPeerException $e)
    {
      return null;
    }
  }

  public function getValues()
  {
    $values = array();
    $archs = ArchPeer::doSelect(new Criteria);
    //TODO some callback to a statement.
    foreach ($archs as $arch)
    {
      $values[$arch->getId()] = $arch->getName();
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
