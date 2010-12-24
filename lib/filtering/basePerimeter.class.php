<?php
abstract class basePerimeter
{

  abstract public function addSelectColumns(Criteria $criteria);
  abstract public function addTemporayTableColumns(Criteria $criteria);
  abstract public function getJoinToTemporaryTable();

}
