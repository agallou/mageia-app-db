<?php
class packagePerimeter extends basePerimeter
{

  public function addSelectColumns(Criteria $criteria)
  {
    PackagePeer::addSelectColumns($criteria);
    return $criteria;
  }

}
