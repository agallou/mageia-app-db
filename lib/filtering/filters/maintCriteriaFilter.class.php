<?php 
class maintCriteriaFilter extends baseCriteriaFilterChoice
{

  public function getPerimeter()
  {
    return filterPerimeters::PACKAGE;
  }

  public function getValues()
  {
    $values = array();
    $criteria = new Criteria;
    $criteria->addSelectColumn(PackagePeer::MAINTAINER);
    $criteria->addGroupByColumn(PackagePeer::MAINTAINER);
    $criteria->addAscendingOrderByColumn(PackagePeer::MAINTAINER);
    $stmt = BasePeer::doSelect($criteria);
    foreach ($stmt->fetchAll() as $row)
    {
      $values[$row[0]] = $row[0];
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
    if ($value != "")
    {
      $criteria->addAnd(PackagePeer::MAINTAINER, $value, Criteria::IN);
    }
    return $criteria;
  }

  public function getCode()
  {
    return 'maint';
  }

  /**
   * name 
   * 
   * @return void
   */
  public function getName()
  {
    return 'Maintainers';
  }
}
