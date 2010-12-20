<?php
class rpmPerimeter extends basePerimeter
{
  public function addSelectColumns(Criteria $criteria)
  {
    RpmPeer::addSelectColumns($criteria);
    return $criteria;
  }

  public function addTemporayTableColumns(Criteria $criteria)
  {
    $criteria->addSelectColumn(RpmPeer::ID);
    return $criteria;
  }
}
