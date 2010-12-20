<?php
class rpmPerimeter extends basePerimeters
{
  public function addSelectColumns(Criteria $criteria)
  {
    RpmPeer::addSelectColumns($criteria);
    return $criteria;
  }

}
