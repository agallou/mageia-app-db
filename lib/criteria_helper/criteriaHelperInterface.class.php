<?php

interface criteriaHelperInterface
{

  public function splitPart($text, $delimiter, $count);
  public function createTable($name, $temporary = true);

}
