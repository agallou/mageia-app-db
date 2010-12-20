<?php
class packagePerimeter extends basePerimeter
{

  public function addSelectColumns(Criteria $criteria)
  {
    PackagePeer::addSelectColumns($criteria);
    return $criteria;
  }

public function addTemporayTableColumns(Criteria $criteria)
  {
    $criteria->addSelectColumn(PackagePeer::ID);
    return $criteria;
  }


}
