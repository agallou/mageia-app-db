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
    $criteria->addAsColumn('id', RpmPeer::PACKAGE_ID);
    $criteria->setPrimaryTableName(RpmPeer::TABLE_NAME);
    return $criteria;
  }

  public function getJoinToTemporaryTable()
  {
    return new Join();
  }

}
