<?php

interface criteriaHelperInterface
{

  public function splitPart($text, $delimiter, $count);
  public function createTableFromCriteria(Criteria $criteria, $tablename, $temporary);

}
